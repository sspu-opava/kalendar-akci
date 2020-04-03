<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;

/**
 * Users management.
 */
final class AkceManager {

    use Nette\SmartObject;

    private const
            TABLE_NAME = 'akce',
            COLUMN_ID = 'id_akce',
            COLUMN_NAZEV = 'nazev',
            COLUMN_DATUM = 'datum',
            COLUMN_KATEGORIE = 'kategorie',
            COLUMN_POPIS = 'popis',
            COLUMN_HODNOCENI = 'hodnoceni';

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /* Výpis všech záznamů z dané tabulky 
     * $order - určuje řazení záznamů podle vybraného sloupce tabulky
     */
    public function getAll($order = self::COLUMN_NAZEV) {
        return $this->database->table(self::TABLE_NAME)->order($order)->fetchAll();
    }

    /* Výpis jednoho záznamu podle id
     * $id - obsahuje odkaz na primární klíč vybraného záznamu
     */
    public function getById($id) {
        return $this->database->table(self::TABLE_NAME)->get($id);
    }
    
    /* Vložení nového záznamu
     * $values - asociativní pole obsahující data vkládaného záznamu
     */
    public function insert($values) {
        try 
        {
            $this->database->table(self::TABLE_NAME)->insert($values);
            return true;
        } 
		catch (Nette\Database\DriverException $e) 
		{
			return false;
		}	
    }

    /* Aktualizace záznamu
     * $id - odkaz na primární klíč aktualizovaného záznamu
     * $values - asociativní pole obsahující data aktualizovaného záznamu
     */
    public function update($id, $values) {
        if ($zaznam = $this->getById($id)) return $zaznam->update($values);
        return false;
    }
    
    /* Vymazání záznamu
     * $id - odkaz na primární klíč odstraňovaného záznamu
     */
    public function delete($id) {
        if ($zaznam = $this->getById($id)) return $zaznam->delete();
        return false;
    }
}
