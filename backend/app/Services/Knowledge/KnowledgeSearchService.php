<?php

namespace App\Services\Knowledge;

use App\Models\KnowledgeArticle;

class KnowledgeSearchService
{
    public function findSimilar(
        string $query
    )
    {
        $terms = explode(
            ' ',
            strtolower($query)
        );

        return KnowledgeArticle::query()

            ->where(function ($builder) use ($terms) {

                foreach ($terms as $term) {

                    if (strlen($term) < 3) {
                        continue;
                    }

                    $builder->orWhere(
                        'title',
                        'like',
                        "%{$term}%"
                    );

                    $builder->orWhere(
                        'problem',
                        'like',
                        "%{$term}%"
                    );
                }
            })

            ->select([
                'id',
                'title',
                'problem',
            ])

            ->limit(5)

            ->get();
    }
}