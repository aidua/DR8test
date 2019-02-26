<?php

namespace Drupal\curmodule;

use Drupal\Core\Database\Connection;

/**
 * Defines a storage handler class that handles the node grants system.
 * This is used to build node query access.
 *
 * @ingroup curmodule
 */
class CurmoduleDbLogic {

    /**
     * The database connection.
     * @var \Drupal\Core\Database\Connection
     */
    protected $database;

    /**
     * Constructs a CurmoduleDbLogic object.
     * @param \Drupal\Core\Database\Connection $database
     * The database connection.
     */
    // Змінна $database прилетіла до нас з аргументу сервісу.
    public function __construct(Connection $database) {
        $this->database = $database;
    }

    /**
     * Додаємо новий запис в таблицю nbu_table_info.
     */
    public function add_currency($kod1, $kod2, $name) {
        if (empty($kod1) || empty($kod2) || empty($name)) {
            return FALSE;
        }
        // Приклад роботи з БД в Drupal 8.
        $query = $this->database->insert('nbu_table_info');
        $query->fields([
            'kod1' => $kod1,
            'kod2' => $kod2,
            'name' => $name,
            'active' => 1,
        ]);
        return $query->execute();
    }

    /**
     * Додаємо новий запис в таблицю nbu_table_data.
     */
    public function add_exchange($id_inf, $exchange, $date) {
        if (empty($id_inf) || empty($exchange) || empty($date)) {
            return FALSE;
        }
        // Приклад роботи з БД в Drupal 8.
        $query = $this->database->insert('nbu_table_data');
        $query->fields([
            'id_inf' => $id_inf,
            'exchange' => $exchange,
            'date' => $date,
        ]);
        return $query->execute();
    }

    /**
     * Отримати ВСІ записи з таблиці mypage.
     */
    public function getAll() {
        return $this->getById();
    }

    /**
     * Отримати записи по ID з таблиці mypage.
     */
    public function getById($id = NULL, $reset = FALSE) {
        $query = $this->database->select('mypage');
        $query->fields('mypage', array('id', 'title', 'body'));
        if ($id) {
            $query->condition('id', $id);
        }
        $result = $query->execute()->fetchAll();
        if (count($result)) {
            if ($reset) {
                $result = reset($result);
            }
            return $result;
        }
        return FALSE;
    }

}