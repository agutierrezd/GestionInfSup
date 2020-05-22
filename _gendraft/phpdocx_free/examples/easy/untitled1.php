<?php 
require_once '../../classes/CreateDocx.inc';

$docx = new CreateDocx();

$html='http://www.2mdc.com/PHPDOCX/simpleHTML.html';

$html='<p>This is a simple paragraph with <strong>text in bold</strong>.</p>
<p>Now we include a list:</p>
<ul>
    <li>First item.</li>
    <li>Second item with subitems:
        <ul>
            <li>First subitem.</li>
            <li>Second subitem.</li>
        </ul>
    </li>
    <li>Third subitem.</li>
</ul>
<p>And now a table:</p>
<table>
    <tbody><tr>
        <td>Cell 1 1</td>
        <td>Cell 1 2</td>
    </tr>
    <tr>
        <td>Cell 2 1</td>
        <td>Cell 2 2</td>
    </tr>
</tbody></table>';

$docx->embedHTML($html);

$docx->createDocx('../docx/simpleHTML');

?>