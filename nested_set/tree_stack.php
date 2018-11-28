<?php


$treeSource = [
    [
        'id' => 1,
        'children' => [
            [
                'id' => 2,
                'children' => [
                    [
                        'id' => 3,
                        'children' => [
                            [
                                'id' => 4,
                            ],
                            [
                                'id' => 5,
                            ],
                        ]
                    ]
                ]
            ],
            [
                'id' => 7,
                'children' => [
                    [
                        'id' => 8,
                    ],
                    [
                        'id' => 9,
                    ]
                ],
            ],
        ],
    ],
    [
        'id' => 10,
        'children' => [
            [
                'id' => 11,
            ]
        ]
    ]
];


$l = 0;

$stack = [];

foreach ($treeSource as $i => $node) {
    $stack[] = &$treeSource[$i];
}

while (!empty($stack)) {
    reset($stack);
    $idx = key($stack);
    $node = &$stack[$idx];
    $passed = !empty($node['left']);

    if (!$passed) {

        $node['left'] = ++$l;
    }

    if ($passed || empty($node['children'])) {
        $node['right'] = ++$l;
        unset($stack[$idx]);
    } else {
        $children = [];
        foreach ($node['children'] as $i => $child) {
            $children[] = &$node['children'][$i];
        }

        if (!empty($children)) {
            $stack = array_merge($children, $stack);
        }
    }
}

function validateNode($node, $id, $l, $r)
{
    if ($node['id'] !== $id || $node['left'] !== $l || $node['right'] !== $r) {
        throw new ErrorException('Fail');
    }
}

validateNode($treeSource[0], 1, 1, 16);
validateNode($treeSource[0]['children'][0], 2, 2, 9);
validateNode($treeSource[0]['children'][1], 7, 10, 15);
validateNode($treeSource[0]['children'][0]['children'][0], 3, 3, 8);
validateNode($treeSource[0]['children'][0]['children'][0]['children'][0], 4, 4, 5);
validateNode($treeSource[0]['children'][0]['children'][0]['children'][1], 5, 6, 7);
validateNode($treeSource[0]['children'][1]['children'][0], 8, 11, 12);
validateNode($treeSource[0]['children'][1]['children'][1], 9, 13, 14);
validateNode($treeSource[1], 10, 17, 20);
validateNode($treeSource[1]['children'][0], 11, 18, 19);

