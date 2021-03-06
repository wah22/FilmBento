<?php

class SettingsManager extends Model {

    private static $instance;
    
    private function __contruct() {
        parent::__construct();
    }

    static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new SettingsManager();
        }
        return self::$instance;
    }

    function getSetting($setting) {
        $stmt = $this->pdo->prepare('SELECT * FROM fbo_settings WHERE name = :name');
        $stmt->bindParam(':name', $setting);
        $stmt->execute();
        $row = $stmt->fetch();
        $setting = $row['value'];

        return $setting;
    }

    function setSetting($setting, $value) {
        $update = $this->pdo->prepare('UPDATE fbo_settings SET value = :value WHERE name = :setting');
        $update->bindValue(':setting', $setting);
        $update->bindValue(':value', $value);
        $update->execute();
    }
}
