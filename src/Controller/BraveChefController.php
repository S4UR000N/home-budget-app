<?php

namespace App\Controller;

use AppBundle\Entity\Reward;
use AppBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

class BraveChefController
{
    /**
     * Creates new User account.
     */
    #[Route('/api/user/create', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Returns true or false',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AlbumDto::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'order',
        in: 'query',
        description: 'The field used to order rewards',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'rewards')]
    #[Security(name: 'Bearer')]
    public function fetchUserRewardsAction(User $user)
    {
        // ...
    }
}

?>