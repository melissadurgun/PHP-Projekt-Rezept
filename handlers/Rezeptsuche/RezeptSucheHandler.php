<?php
require_once('../../config/db.php');

class RezeptSucheHandler
{
    private $DB;

    public function __construct()
    {
        // Datenbankverbindung aufbauen
        $this->DB = new DB();
    }

    // Methode, um zu prüfen, ob Filter gesetzt sind
    public function hasFilters($filters)
    {
        return !empty(array_filter($filters, function ($value) {
            return $value !== 'keinFilter' && $value !== '';
        }));
    }

    // Methode, um Rezepte basierend auf Filterkriterien abzurufen
    public function getRezepte($filters)
    {
        // SQL-Query und Parameter dynamisch erstellen
        $queryData = $this->buildSQLQuery($filters);
        $sql = $queryData['sql'];
        $parameters = $queryData['parameters'];

        // Abfrage vorbereiten und ausführen
        $rezepteQuery = $this->DB->prepare($sql);
        $rezepteQuery->execute($parameters);

        // Ergebnisse abrufen
        $rezepte = $rezepteQuery->fetchAll(PDO::FETCH_ASSOC);

        // Base64-kodierte Bilder hinzufügen
        foreach ($rezepte as &$rezept) {
            if (!empty($rezept['bild'])) {
                $rezept['bild'] = 'data:image/jpeg;base64,' . base64_encode($rezept['bild']);
            } else {
                $rezept['bild'] = '../../assets/images/ImagePlaceholder.jpg'; // Fallback-Bild
            }
        }

        return $rezepte;
    }

    // Methode zum Erstellen des SQL-Strings und der Parameter
    private function buildSQLQuery($filters)
    {
        $sql = 'SELECT rezept_id, titel, zubereitungsdauer, schwierigkeitsgrad, ernaehrung, mahlzeitkategorie, kueche, bild
                FROM rezept WHERE 1=1';
        $parameters = [];

        // Filter hinzufügen, falls vorhanden        
        if (!empty($filters['zubereitungsdauer']) && $filters['zubereitungsdauer'] != 'keinFilter') {
            $sql .= ' AND zubereitungsdauer = :zubereitungsdauer';
            $parameters[':zubereitungsdauer'] = $filters['zubereitungsdauer'];
        }

        if (!empty($filters['ernaehrung']) && $filters['ernaehrung'] != 'keinFilter') {
            $sql .= ' AND ernaehrung = :ernaehrung';
            $parameters[':ernaehrung'] = $filters['ernaehrung'];
        }

        if (!empty($filters['schwierigkeitsgrad']) && $filters['schwierigkeitsgrad'] != 'keinFilter') {
            $sql .= ' AND schwierigkeitsgrad = :schwierigkeitsgrad';
            $parameters[':schwierigkeitsgrad'] = $filters['schwierigkeitsgrad'];
        }

        if (!empty($filters['mahlzeit']) && $filters['mahlzeit'] != 'keinFilter') {
            $sql .= ' AND mahlzeitkategorie = :mahlzeit';
            $parameters[':mahlzeit'] = $filters['mahlzeit'];
        }

        if (!empty($filters['kueche']) && $filters['kueche'] != 'keinFilter') {
            $sql .= ' AND kueche = :kueche';
            $parameters[':kueche'] = $filters['kueche'];
        }

        if (!empty($filters['search'])) {
            $sql .= ' AND titel LIKE :search';
            $parameters[':search'] = '%' . $filters['search'] . '%';
        }

        // Sortieren nach neuestem Rezept zuerst
        $sql .= ' ORDER BY rezept_id DESC';

        return ['sql' => $sql, 'parameters' => $parameters];
    }
}
