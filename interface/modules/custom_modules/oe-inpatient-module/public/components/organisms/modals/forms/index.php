<?php

function renderformsModal($formContent)
{
    $modalContents = $formContent['modalContents'] ?? ['main' => '<p>No content provided.</p>'];


    echo <<<HTML
    <div id="formsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-[500px] mx-auto px-6 relative">
        <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"
            onclick="closeformsModal()">
            &times;
        </button>

            <div id="formsDynamicContentArea">
HTML;
    // CLOSE HEREDOC HERE, THEN EXECUTE PHP CODE
    foreach ($modalContents as $key => $contentHtml) {
        echo $contentHtml; // This will output the HTML string for each content part
    }
    // REOPEN HEREDOC FOR THE CLOSING DIVS
    echo <<<HTML
            </div>

        </div>
    </div>
    HTML;
}
