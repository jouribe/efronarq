<?php

namespace App\Utils;

use PhpOffice\PhpWord\TemplateProcessor;

class WordProcessor extends TemplateProcessor
{
    /**
     * Replace a block.
     *
     * @param string $blockname
     * @param string $replacement
     */
    public function replaceBlock($blockname, $replacement)
    {
        preg_match('/\$\{' . $blockname . '}.*\$\{\/' . $blockname . '}/is',
            $this->tempDocumentMainPart, $matches);

        if (isset($matches[0])) {
            $this->tempDocumentMainPart = str_replace($matches[0], $replacement,
                $this->tempDocumentMainPart);
        }
    }
}
