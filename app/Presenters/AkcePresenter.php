<?php

declare(strict_types = 1);

namespace App\Presenters;

/* Použití jmenného prostoru, v němž jsou uloženy třídy tvořící model aplikace */

use App\Model;

/* Použití jmenného prostoru pro přístup ke komponentám UI - uživatelského rozhraní (formuláře) */
use Nette\Application\UI;

/* Použití jmenného prostoru pro přístup k utilitě DateTime */
use Nette\Utils\DateTime;

/* Připojení knihovny Debugger, která je součástí Laděnky (Tracy) */
use Tracy\Debugger;

final class AkcePresenter extends BasePresenter {
    /* Privátní proměnná (atribut třídy), prostřednictvím které je "injektován" model AkceManager */

    private $akceManager;

    /* Metoda konstruktoru. Využití Dependency Injection - při vytváření objektu presenteru se připojí (injektuje) služba AkceManager  */

    public function __construct(Model\AkceManager $akceManager) {
        $this->akceManager = $akceManager;
    }

    /* Metoda zajistí přípravu a rendrování stránky se seznamem všech akcí */

    public function renderList($order = 'datum DESC'): void {
        /* Na začátek stránky budou vypsány ladicí informace - o proměnné order */
        // Debugger:dump('Proměnná order: ', $order);
        /* Příslušné šabloně (list.latte) bude předána proměnná $akceList (pole objektů), 
          do níž budou díky metodě getAll() uloženy všechny záznamy o akcích
          uspořádané podle proměnné $order */
        $this->template->akceList = $this->akceManager->getAll($order);
    }

    /* Metoda zajistí přípravu a rendrování stránky pro detail jedné akce */

    public function renderDetail($id): void {
        /* Do okna ve spodní liště bude vložena ladicí informace o stavu proměnné $id */
        // Debugger::barDump('Proměnná id: ', $id); 
        /* Příslušné šabloně (detail.latte) bude předána proměnná $akce, 
          do níž bude díky metodě getById() uložen záznam (objekt) o akci
          vybrané podle proměnné $id */
        $this->template->akce = $this->akceManager->getById($id);
    }

    /* Metoda zajistí přípravu vložení nové akce a poté vyrendruje stránku s formulářem */

    public function actionInsert(): void {
        Debugger::log('Vložen nový záznam');
        /* Vytvoření objektu s aktuálním dato/časovým údajem */
        $dnes = new DateTime();
        /* Nastavení výchozích hodnot do některých formulářových prvků */
        $this['akceForm']['datum']->setDefaultValue($dnes->format('Y-m-d'));
        $this['akceForm']['hodnoceni']->setDefaultValue('3.0');
        $this['akceForm']['kategorie']->setDefaultValue('kino');
    }

    /* Metoda zajistí přípravu aktualizace akce a poté vyrendruje stránku s formulářem */

    public function actionUpdate($id): void {
        Debugger::log('Aktualizován záznam ' . $id);
        /* Načte záznam o dané akci (podle id) a převede ho na asociativní pole */
        $data = $this->akceManager->getById($id)->toArray();
        /* Převede datum z formátu DateTime na datum ve tvaru rok-měsíc-den */
        $data['datum'] = $data['datum']->format('Y-m-d');
        Debugger::barDump($data);
        /* Nastaví výchozí hodnoty ve formuláři podle předaných dat */
        $this['akceForm']->setDefaults($data);
    }

    /* Metoda provede smazání záznamu o akci a poté přesměruje zpět na seznam akcí */

    public function actionDelete($id): void {
        Debugger::log('Odstraněn záznam ' . $id);
        if ($this->akceManager->delete($id)) {
            $this->flashMessage('Záznam byl úspěšně smazán', 'success');
        } else {
            $this->flashMessage('Došlo k nějaké chybě při mazání záznamu', 'danger');
        }
        $this->redirect('list');
    }

    /* Komponenta ("továrna") formuláře */

    protected function createComponentAkceForm(): UI\Form {
        $form = new UI\Form;

        $form->addText('nazev', 'Název akce:')
                /* Pravidlo je definováno pomocí regulárního výrazu */
                ->addRule(UI\Form::PATTERN, 'Musí obsahovat aspoň 5 znaků', '.{5,}')
                /* Údaj je povinný */
                ->setRequired(true);

        $form->addText('datum', 'Datum konání akce:')
                /* Nastavení typu vstupního pole */
                ->setHtmlType('date')
                ->setRequired(true);

        $form->addTextArea('popis', 'Stručný popis:')
                /* Vložení atributu do formulářového prvku */
                ->setHtmlAttribute('rows', '6')
                ->setRequired(true);

        /* Asociativní pole definuje předvolby, které je možné použít u prvků
         * select nebo radio */
        $kategorie = [
            'divadlo' => 'divadlo',
            'hudba' => 'hudba',
            'kino' => 'kino',
            'výstava' => 'výstava'
        ];
        $form->addSelect('kategorie', 'Kategorie:', $kategorie);

        $form->addText('hodnoceni', 'Hodnocení:')
                ->setHtmlType('number')
                ->setHtmlAttribute('min', '1.0')
                ->setHtmlAttribute('max', '5.0')
                ->setHtmlAttribute('step', '0.1')
                ->setHtmlAttribute('title', 'Zadejte hodnocení v rozsahu 1.0 až 5.0')
                /* Validační pravidlo nastavuje rozsah platných hodnot */
                ->addRule(UI\Form::RANGE, 'Hodnocení musí být v rozsahu od 1.0 do 5.0', [1.0, 5.0]);

        $form->addSubmit('submit', 'Potvrdit');

        $form->onSuccess[] = [$this, 'akceFormSucceeded'];
        return $form;
    }

    /* Volá se po úspěšném odeslání formuláře */

    public function akceFormSucceeded(UI\Form $form, $values): void {
        Debugger::barDump($values);
        /* Do proměnné $akceId uložíme informaci o id, které je v případě update předáváno ve formě parametru */
        $akceId = $this->getParameter('id');

        /* Pokud proměnná $akceId obsahuje nějaký údaj (není tedy false)... */
        if ($akceId) {
            /* předpokládáme akci update a použijeme připravenou metodu update, která je součástí AkceManager...  */
            $akce = $this->akceManager->update($akceId, $values);
        } else {
            /* ...v opačném případě hodláme vložit nový záznam metodou insert */
            $akce = $this->akceManager->insert($values);
        }
        /* Jestliže návratová hodnota uložená v proměnné $akce byla true */
        if ($akce) {
            /* zobrazíme "úspěšnou" zprávu na zeleném pozadí... */
            $this->flashMessage('Akce byla úspěšně uložena', 'success');
        } else {
            /* ...jinak se zobrazí chybová zpráva na červeném pozadí */
            $this->flashMessage('Došlo k nějaké chybě při ukládání do databáze', 'danger');
        }
        /* Přesměrování na stránku se seznamem akcí - tj. presenter Akce, metoda list */
        $this->redirect('Akce:list');
    }

}
