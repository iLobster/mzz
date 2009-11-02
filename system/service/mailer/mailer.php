<?php
class mailer
{
    const DEFAULT_CONFIG_NAME = 'default';
    protected static $instances = array();

    public static function factory($configName = self::DEFAULT_CONFIG_NAME, $configs = null)
    {
        $configs = empty($configs) ? systemConfig::$mailer : $configs;

        if ($configName == self::DEFAULT_CONFIG_NAME && !isset($configs[self::DEFAULT_CONFIG_NAME])) {
            throw new mzzRuntimeException('no default mailer configuration name');
        }

        if (!isset($configs[$configName])) {
            throw new mzzUnknownMailConfigException($configName);
        }

        $config = $configs[$configName];
        if (!isset(self::$instances[$configName])) {
            $className = 'f' . ucfirst($config['backend']) . 'Mailer';
            $params = isset($config['params']) ? $config['params'] : array();
            try {
                fileLoader::load('service/mailer/' . $className);
                $notFound = !class_exists($className);
            } catch (mzzIoException $e) {
                $notFound = true;
            }
            if ($notFound || empty($config['backend'])) {
                throw new mzzUnknownMailBackendException($className);
            }

            self::$instances[$configName] = new $className($params);
        }

        return self::$instances[$configName];
    }
}
?>