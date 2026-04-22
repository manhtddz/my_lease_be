<?php

namespace Core\Database\Connectors;

use Illuminate\Database\Connectors\PostgresConnector;

class BasePostgresConnector extends PostgresConnector
{
    /**
     * Set the application name on the connection.
     *
     * @param \PDO $connection
     * @param array $config
     */
    protected function configureApplicationName($connection, $config)
    {
        $applicationName = $this->_getApplicationName($config);

        if (!empty($applicationName)) {
            $connection->prepare("set application_name to '$applicationName'")->execute();
        }
    }

    /**
     * @param $config
     * @return string
     */
    private function _getApplicationName($config): string
    {
        if (!empty($config['application_name'])) {
            return $config['application_name'];
        }

        return getConfig('postgres_application_prefix') . '-' . getArea();
    }
}
