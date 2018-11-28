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

processTreeRecursive($treeSource, $l);

function processTreeRecursive(array &$nodes, &$l)
{
    foreach ($nodes as $i => $node) {
        $l ++;

        $nodes[$i]['left'] = $l;

        $children = $node['children'] ?? [];

        if (!empty($node['children'])) {
            processTreeRecursive($children, $l);
        }

        $nodes[$i]['children'] = $children;
        $nodes[$i]['right'] = ++$l;
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


