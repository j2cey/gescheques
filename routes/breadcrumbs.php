<?php

use App\Models\Cheque;
use App\Models\Workflow;
use Tabuna\Breadcrumbs\Trail;
use Tabuna\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Accueil', route('home'));
});

// System
Breadcrumbs::for('systems.index', function (Trail $trail) {
    $trail->parent('home')->push('System', route('systems.index'));
});

// Wokflows
Breadcrumbs::for('workflows.index', function (Trail $trail) {
    $trail->parent('home')->push('Workflows', route('workflows.index'));
});
Breadcrumbs::for('workflows.flowchart', function (Trail $trail, Workflow $workflow) {
    $trail->parent('workflows.index')
        ->push('Diagramme', route('workflows.flowchart', $workflow->uuid));
});

// Encaissements
Breadcrumbs::for('encaissements.index', function (Trail $trail) {
    $trail->parent('home')->push('Encaissements', route('encaissements.index'));
});
Breadcrumbs::for('encaissements.upload', function (Trail $trail) {
    $trail->parent('encaissements.index')->push('Téléchargement', route('encaissements.upload'));
});

// Cheques
Breadcrumbs::for('cheques.index', function (Trail $trail) {
    $trail->parent('home')->push('Chèques', route('cheques.index'));
});
Breadcrumbs::for('cheques.upload', function (Trail $trail) {
    $trail->parent('cheques.index')->push('Téléchargement', route('cheques.upload'));
});
Breadcrumbs::for('cheques.show', function (Trail $trail, Cheque $cheque) {
    $trail->parent('cheques.index')
        ->push('Détails', route('cheques.show', $cheque->uuid));
});
