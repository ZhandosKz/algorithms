<?php

class Item
{
    public $id;

    public $left;
    public $right;
    public $level;
    public $passed = false;

    public $children = [];

    public function __construct($id, array $children = [])
    {
        $this->id = $id;
        $this->children = $children;
    }
}

$treeSource = [
    new Item(1, [
        new Item(2, [
            new Item(3, [
                new Item(4),
                new Item(5),
            ])
        ]),
        new Item(7, [
            new Item(8),
            new Item(9),
        ])
    ]),
    new Item(10, [
        new Item(11)
    ]),
];



$stack = $treeSource;

$l = 0;
$lastParentLevel = 1;

while (!empty($stack)) {
    reset($stack);

    $idx = key($stack);
    $node = $stack[$idx];

    $passed = $node->passed;

    if (!$passed) {
        $node->left = ++$l;
        $node->passed = true;
        $node->level = $lastParentLevel;
    }

    if (!$passed && !empty($node->children)) {
        $lastParentLevel ++;
        $stack = array_merge($node->children, $stack);
    } else {
        $node->right = ++$l;
        unset($stack[$idx]);
        if ($passed) {
            $lastParentLevel--;
        }
    }
}


function validateNode($node, $id, $l, $r, $level)
{
    if ($node->id !== $id || $node->left !== $l || $node->right !== $r || $node->level !== $level) {
        throw new ErrorException('Fail');
    }
}

validateNode($treeSource[0], 1, 1, 16, 1);
validateNode($treeSource[0]->children[0], 2, 2, 9, 2);
validateNode($treeSource[0]->children[1], 7, 10, 15, 2);
validateNode($treeSource[0]->children[0]->children[0], 3, 3, 8, 3);
validateNode($treeSource[0]->children[0]->children[0]->children[0], 4, 4, 5, 4);
validateNode($treeSource[0]->children[0]->children[0]->children[1], 5, 6, 7, 4);
validateNode($treeSource[0]->children[1]->children[0], 8, 11, 12, 3);
validateNode($treeSource[0]->children[1]->children[1], 9, 13, 14, 3);
validateNode($treeSource[1], 10, 17, 20, 1);
validateNode($treeSource[1]->children[0], 11, 18, 19, 2);

