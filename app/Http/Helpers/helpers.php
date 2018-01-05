<?php

if (! function_exists('generateFoodCategoryLists')) {
    function generateFoodCategoryLists(array $elements, array $items, $parentId = 0, $indent = 0)
    {
        foreach ($elements as $key => $element) {
            if ($element['parent_id'] == $parentId) {
                echo '<option value ="' . $element['id'] . '" disabled>';
                echo ($indent != 0) ? str_repeat("&mdash; ", $indent) : '';
                echo $element['name'];
                foreach ($items as $key => $item) {
                    if ($item['category_id'] == $element['id']) {
                        echo '<option value="' . $item['id'] . '">';
                        echo ($indent != 0) ? str_repeat("&nbsp;&nbsp; ", $indent) : '';
                        echo $item['name'];
                        echo '</option>';
                    }
                }
                $children = generateFoodCategoryLists($elements, $items, $element['id'], $indent + 1);
            }
        }
    }
}

if (! function_exists('generateFoodCategoryListsEdit')) {
    function generateFoodCategoryListsEdit(array $elements, array $items, $parentId = 0, $indent = 0,$favourite)
    {
        foreach ($elements as $key => $element) {
            if ($element['parent_id'] == $parentId) {
                echo '<option value ="' . $element['id'] . '" disabled>';
                echo ($indent != 0) ? str_repeat("&mdash; ", $indent) : '';
                echo $element['name'];
                foreach ($items as $key => $item) {
                    if ($item['category_id'] == $element['id']) {
                        $selected = (in_array($item['id'],$favourite)) ? 'selected' :'';
                        if($selected){
                            echo '<option selected value="' . $item['id'] . '">';
                        }else{
                            echo '<option value="' . $item['id'] . '">';
                        }
                        echo ($indent != 0) ? str_repeat("&nbsp;&nbsp; ", $indent) : '';
                        echo $item['name'];
                        echo '</option>';
                    }
                }
                $children = generateFoodCategoryListsEdit( $elements, $items, $element['id'], $indent + 1,$favourite);
            }
        }
    }
}

if (! function_exists('generateCategoryLists')) {
    function generateCategoryLists(array $elements, $parentId = 0,$indent = 0) {
        foreach ($elements as $key => $element) {
            
            if ($element['parent_id'] == $parentId) {
                echo '<option value ="'. $element['id'] .'">';
                echo ($indent != 0) ? str_repeat("&mdash; ", $indent) : '';
                echo $element['name'];

                echo '</option>';
            $children = generateCategoryLists($elements, $element['id'],$indent + 1);

            }
        }
    }
}

//to show dropdown in category edit disabling the category itself, disabling all non-available categories ,and hiding all children of this category
if (! function_exists('generateCategoryListsForEdit')) {
    function generateCategoryListsForEdit(array $elements, $edit, $selected, $subtree, $parentId = 0, $indent = 0)
    {
        foreach ($elements as $key => $element) {
                if ($element['parent_id'] == $parentId) {
                    if($selected == $element['id']){
                        echo '<option  value ="' . $element['id'] . '" selected>';
                    }
                    //to select the child of the current id
                    elseif ($edit == $element['parent_id']) {
                            continue;
                        }
                    //to disable all non-available categories
                    elseif ($element['status'] == 0) {
                        echo '<option  value ="' . $element['id'] . '" disabled>';
                    }
                    //a category cannot be the parent of itself
                    elseif ($edit == $element['id']) {
                        echo '<option  value ="' . $element['id'] . '" disabled>';
                    }
                    //this is normal case which is none of the above cases
                    else {
                        echo '<option value ="' . $element['id'] . '">';
                    }
                    //prints the indents and option name
                    echo ($indent != 0) ? str_repeat("&mdash; ", $indent) : '';
                    echo $element['name'];
                    echo '</option>';
                    $children = generateCategoryListsForEdit($elements, $edit, $selected, $subtree, $element['id'], $indent + 1);

                }
//            }
        }
    }
}


if (! function_exists('generateItemCategoryList')) {

    function generateItemCategoryList(array $elements, $parentId = 0,$indent = 0,$parent_id_arr) {
        foreach ($elements as $key => $element) {
            if ($element['parent_id'] == $parentId) {
                if(in_array($element['id'], $parent_id_arr) || $element['status'] == 0) {
                    echo '<option  value ="' . $element['id'] . '" disabled>';
                }
                else{
                    echo '<option value ="' . $element['id'] . '">';//
                }
                    echo ($indent != 0) ? str_repeat("&mdash; ", $indent) : '';
                    echo $element['name'];
                    echo '</option>';
                    $children = generateItemCategoryList($elements, $element['id'], $indent + 1,$parent_id_arr);
            }
        }
    }
}


if (! function_exists('submenusitems')) {
    function submenusitems(array $elements, array $items, $parentId = 0, $indent = 0, array $continents)
    {
        foreach ($elements as $key => $element) {
            if ($element['parent_id'] == $parentId) {
                echo '<option value ="' . $element['id'] . '" disabled>';
                echo ($indent != 0) ? str_repeat("&mdash; ", $indent) : '';
                echo $element['name'];
                foreach ($items as $key => $item) {
                    if ($item['category_id'] == $element['id']) {
                        echo '<option value="' . $item['id'] . '">';
                        echo ($indent != 0) ? str_repeat("&nbsp;&nbsp; ", $indent) : '';
                        echo $item['name'];
                        if ($item['has_continent'] == 1) {
                            foreach($continents as $key => $continent) {
                                if ($continent['id'] == $item['continent_id']) {
                                    echo "(" . $continent['name'] . ")";
                                }
                            }
                        }
                        echo '</option>';
                    }
                }

                $children = submenusitems($elements, $items, $element['id'], $indent + 1, $continents);
            }
        }
    }
}

if (! function_exists('submenusitemsEdit')) {
    function submenusitemsEdit(array $elements, array $items, $parentId = 0, $indent = 0, $sub_item, array $continents)
    {
        foreach ($elements as $key => $element) {
            if ($element['parent_id'] == $parentId) {
                echo '<option value ="' . $element['id'] . '" disabled>';
                echo ($indent != 0) ? str_repeat("&mdash; ", $indent) : '';
                echo $element['name'];
                foreach ($items as $key => $item) {
                    if ($item['category_id'] == $element['id']) {
                        $selected = (in_array($item['id'],$sub_item)) ? 'selected' :'';
                        if($selected){
                            echo '<option selected value="' . $item['id'] . '">';
                        }else{
                            echo '<option value="' . $item['id'] . '">';
                        }
                        echo ($indent != 0) ? str_repeat("&nbsp;&nbsp; ", $indent) : '';
                        echo $item['name'];
                        if ($item['has_continent'] == 1) {
                            foreach($continents as $key => $continent) {
                                if ($continent['id'] == $item['continent_id']) {
                                    echo "(" . $continent['name'] . ")";
                                }
                            }
                        }
                        echo '</option>';
                    }
                }
                $children = submenusitemsEdit( $elements, $items, $element['id'], $indent + 1,$sub_item, $continents);
            }
        }
    }
}


?>


