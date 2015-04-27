<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 4/25/2015
 * Time: 4:06 PM
 */

class DocumentView {
    public function __construct(Site $site) {
        $this->site = $site;
        $this->document = new Document($site);
    }

    public function getDocumentTree($curr_docid, $curr_p_docid, $curr_vnum, $filename) {
        $doc_tree = array();

        while(true) {
            $par_doc = $this->document->getDocumentById($curr_p_docid);

            if($par_doc === false)
            {
                break;
            }

            $par_version_num = $par_doc['versionNo'];

            if ($par_version_num == "1") {
                //$doc_tree[$curr_parent_docid] = $curr_docid;
                $doc_tree[$par_version_num] = $curr_vnum;
                break;
            }
            else {
                // Add to the array, and then swap the values and
                // loop again
                $doc_tree[$par_version_num] = $curr_vnum;
                //$doc_tree[$curr_parent_docid] = $curr_docid;

                $curr_docid = $curr_p_docid;
                $curr_p_docid = $par_doc['parentDocID'];
                $curr_vnum = $par_version_num;
            }
        }

        // ksort should sort the array in ascending order based on the
        // value of the key
        ksort($doc_tree);
        $padding = 5;

        $html = "<div class='tree_view'>";
        $html .= "<h2>Document Tree</h2>";
        $depth = 0;
        foreach($doc_tree as $key => $val) {
            // If depth is 0 then add both the key and the value. Otherwise
            // just add the value.
            if($depth == 0) {
                $html .= "<p style='padding-left: " . $padding . "px'>" . $filename . " version - " . $key . "</p>";
                $padding += 5;
                $html .= "<p style='padding-left: " . $padding . "px'>" . $filename . " version - " . $val . "</p>";
            }
            else {
                $html .= "<p style='padding-left: " . $padding . "px'>" . $filename . " version - " . $val . "</p>";
            }

            $depth++;
            $padding += 5;
            //echo "The parent of: ".$val." is: ".$key."<br/>";
        }

        $html .= "</div>";
        return $html;
    }
    private $site;
    private $document;
}