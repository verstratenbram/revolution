<?php
/*
 * This file is part of MODX Revolution.
 *
 * Copyright (c) MODX, LLC. All Rights Reserved.
 *
 * For complete copyright and license information, see the COPYRIGHT and LICENSE
 * files found in the top-level directory of this distribution.
 */

/**
 * Renames a file
 *
 * @param string $file The file to rename
 * @param string $newname The new name for the file
 *
 * @package modx
 * @subpackage processors.browser
 */
require_once dirname(__DIR__) . '/browser.class.php';

class modBrowserFolderRenameProcessor extends modBrowserProcessor
{
    public $permission = 'directory_update';
    public $policy = 'save';
    public $languageTopics = ['file'];


    /**
     * @return array|mixed|string
     */
    public function process()
    {
        $path = $this->sanitize($this->getProperty('path'));
        if (empty($path)) {
            $this->addFieldError('path', $this->modx->lexicon('file_folder_err_ns'));
        }
        $name = $this->sanitize($this->getProperty('name'));
        if (empty($path)) {
            $this->addFieldError('name', $this->modx->lexicon('name_err_ns'));
        }
        $pathBases = $this->source->getBases($path);
        if (in_array($pathBases['pathAbsoluteWithPath'], $this->getProtectedPathDirectories())) {
            return $this->failure($this->modx->lexicon('permission_denied'));
        }
        if ($this->hasErrors()) {
            return $this->failure();
        }
        $response = $this->source->renameContainer($path, $name);

        return $this->handleResponse($response);
    }
}

return 'modBrowserFolderRenameProcessor';
