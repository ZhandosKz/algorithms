<?php

class Item
{
    public $id;

    public $left;
    public $right;
    public $level;

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
        new Item(11, [
            new Item(14, [
                new Item(15, [
                    new Item(16),
                ]),
            ]),
        ]),
    ]),
    new Item(20),
];

$l = 0;

processTreeRecursive($treeSource, $l, 1);

function processTreeRecursive(array $nodes, &$l, $level)
{
    foreach ($nodes as $i => $node) {
        $node->left = ++$l;
        $node->level = $level;

        if (!empty($node->children)) {
            processTreeRecursive($node->children, $l, $node->level + 1);
        }

        $node->right = ++$l;
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
validateNode($treeSource[1], 10, 17, 26, 1);
validateNode($treeSource[1]->children[0], 11, 18, 25, 2);
validateNode($treeSource[1]->children[0]->children[0], 14, 19, 24, 3);
validateNode($treeSource[1]->children[0]->children[0]->children[0], 15, 20, 23, 4);
validateNode($treeSource[1]->children[0]->children[0]->children[0]->children[0], 16, 21, 22, 5);
validateNode($treeSource[2], 20, 27, 28, 1);

