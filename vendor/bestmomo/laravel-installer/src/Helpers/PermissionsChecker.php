<?php

namespace Bestmomo\Installer\Helpers;

class PermissionsChecker
{
    /**
     * Check for the folders permissions.
     *
     * @return mixed
     */
    public function check()
    {
        foreach(config('installer.permissions') as $folder => $permission)
        {
            if(!($this->getPermission($folder) >= $permission))
            {
                chmod($folder, 0775);
            }
        }

        return true;
    }

    /**
     * Get a folder permission.
     *
     * @param string $folder
     * @return string
     */
    protected function getPermission($folder)
    {
        return substr(sprintf('%o', fileperms(base_path($folder))), -4);
    }
}