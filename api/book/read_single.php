<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Book.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog book object
$book = new book($db);

// Get ID
$book->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get book
$row = $book->read_single();
extract($row);
// Create array
/** @var string $DOC_ID */
/** @var string $COT_NOTICE */
/** @var string $DOC_KEYWORDS */
/** @var string $DOC_TITRE_COMPLEMENT */
/** @var string $DOC_TITRE_PROPRE */
/** @var array $DOC_TITRE_PARALLELE */
/** @var string $DOC_TITRE_ENSEMBLE */
/** @var string $DOC_ANNEE */
/** @var string $DOC_ISBN */
/** @var string $LAN_ID */
/** @var string $PAY_ID */
/** @var string $DOC_NBR_EXEMPLAIRE */
/** @var string $DOC_LIEU_EDITION */
/** @var string $DOC_NBR_UNITE */
/** @var string $DOC_ILLUSTRATION */
/** @var string $DOC_FORMAT */
/** @var string $DOC_NUM */
/** @var string $DOC_ISSN */
/** @var string $DOC_AGENCE */
/** @var string $EDT_NOM_AR */
/** @var string $VED_NOM */
/** @var string $IND_ID */
//(object)
$row['mats'] = explode(',', $row['mats']);
$row['auths'] = explode(',', $row['auths']);
$row['examp_cote'] = explode(',', $row['examp_cote']);
$row['exmp_location'] = explode(',', $row['exmp_location']);
$row['EDT_KEYWORDS'] = array_filter(explode('/', $row['EDT_KEYWORDS']));
$row['DOC_KEYWORDS'] = array_filter(explode('/', $row['DOC_KEYWORDS']));
$book_item = array(
    'leader' => sprintf('%06d', $DOC_ID),
    'fields' => [
        ['010' => [
            'subfields' => [
                ["$" . "a" => $DOC_ISBN]
            ],
            'ind1' => '',
            'ind2' => ''
        ]],
        ['011' => [
            'subfields' => [
                ["$" . "a" => $DOC_ISSN]
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],
        ['017' => [
            'subfields' => [
                ["$" . "a" => $DOC_NUM]
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],
        ['111' => [
            'subfields' => [
                ["$" . "a" => $LAN_ID]
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],
        ['200' => [
            'subfields' => [
                ["$" . "a" => $DOC_TITRE_PROPRE],
                ["$" . "d" => $DOC_TITRE_COMPLEMENT],
                ["$" . "e" => $DOC_TITRE_PARALLELE],
            ],
            'ind1' => '',
            'ind2' => ''
        ]],
        [
            '210' => [
                'subfields' => [
                    ["$" . "a" => $DOC_LIEU_EDITION],
                    ["$" . "c" => $EDT_NOM_AR],
                    ["$" . "d" => $DOC_ANNEE],
                ],
                'ind1' => '',
                'ind2' => ''
            ]
        ],
        ['225' => [
            'subfields' => [
                ["$" . "a" => $DOC_TITRE_ENSEMBLE]
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],
        [
            '215' => [
                'subfields' => [
                    ["$" . "a" => $DOC_NBR_UNITE],
                    ["$" . "d" => $DOC_ILLUSTRATION],
                    ["$" . "c" => $DOC_FORMAT]
                ],
                'ind1' => '',
                'ind2' => ''
            ]
        ],
        ['606' => [
            'subfields' => [
                [$row['mats']]
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],
        ['703' => [
            'subfields' => [
                [$row['auths']]
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],
        [
            '801' => [
                'subfields' => [
                    ["$" . "a" => $PAY_ID],
                    ["$" . "b" => $DOC_AGENCE],
                ],
                'ind1' => '',
                'ind2' => ''
            ]
        ],
        ['901' => [
            'subfields' => [
                [$IND_ID]
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],
        ['995' => [
            'subfields' => [
                ['$' . 'k' => $row['examp_cote']],
                ['$' . 'i' => $row['exmp_location']],
            ],
            'ind1' => '',
            'ind2' => ''
        ]
        ],

        ['999' => [
            'subfields' => [
                [$DOC_NBR_EXEMPLAIRE]
            ],
            'ind1' => '',
            'ind2' => ''
        ]],
    ]
);

// Turn to JSON & output
$books_api = array(
    'bplpName' => 'Bplp ADrar',
    'bplpCode' => '0101',
    'type' => 'marc-json',
    'ApiVersion' => '1.0.0',
    'book' => $book_item
);
print_r(json_encode((object)$books_api));


//print_r( json_encode( array_filter( $row ) ) );