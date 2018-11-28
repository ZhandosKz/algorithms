<?php

class Item
{
    public $id;

    public $left;
    public $right;

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

$l = 0;

processTreeRecursive($treeSource, $l);

function processTreeRecursive(array $nodes, &$l)
{
    foreach ($nodes as $i => $node) {
        $node->left = ++$l;

        if (!empty($node->children)) {
            processTreeRecursive($node->children, $l);
        }

        $node->right = ++$l;
    }
}

function validateNode($node, $id, $l, $r)
{
    if ($node->id !== $id || $node->left !== $l || $node->right !== $r) {
        throw new ErrorException('Fail');
    }
}

validateNode($treeSource[0], 1, 1, 16);
validateNode($treeSource[0]->children[0], 2, 2, 9);
validateNode($treeSource[0]->children[1], 7, 10, 15);
validateNode($treeSource[0]->children[0]->children[0], 3, 3, 8);
validateNode($treeSource[0]->children[0]->children[0]->children[0], 4, 4, 5);
validateNode($treeSource[0]->children[0]->children[0]->children[1], 5, 6, 7);
validateNode($treeSource[0]->children[1]->children[0], 8, 11, 12);
validateNode($treeSource[0]->children[1]->children[1], 9, 13, 14);
validateNode($treeSource[1], 10, 17, 20);
validateNode($treeSource[1]->children[0], 11, 18, 19);

