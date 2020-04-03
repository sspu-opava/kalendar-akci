<?php

declare(strict_types = 1);

namespace App\Presenters;

/* Použití jmenného prostoru, v němž jsou uloženy třídy tvořící model aplikace */

use App\Model;

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
        Debugger:dump('Proměnná order: ', $order);
    }

    /* Metoda zajistí přípravu a rendrování stránky pro detail jedné akce */

    public function renderDetail($id): void {
        /* Do okna ve spodní liště bude vložena ladicí informace o stavu proměnné $id */
        Debugger::barDump('Proměnná id: ', $id);        
    }

    /* Metoda zajistí přípravu vložení nové akce a poté vyrendruje stránku s formulářem */

    public function actionInsert(): void {
        Debugger::log('Vložen nový záznam');
    }

    /* Metoda zajistí přípravu aktualizace akce a poté vyrendruje stránku s formulářem */

    public function actionUpdate($id): void {
        Debugger::log('Aktualizován záznam '.$id);
    }

    /* Metoda provede smazání záznamu o akci a poté přesměruje zpět na seznam akcí */

    public function actionDelete($id): void {
        Debugger::log('Odstraněn záznam '.$id);
        $this->redirect('list');
    }

}
