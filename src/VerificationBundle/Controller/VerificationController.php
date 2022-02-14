<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle\Controller;

use OpenApi\Annotations\Post;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Schema;
use Nelmio\ApiDocBundle\Annotation\Model;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\CreateVerificationRequest;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\VerificationCreated;
use SunFinanceGroup\Notificator\VerificationService\Verifier;

final class VerificationController
{
    public function __construct(private Verifier $verifier)
    {
    }

    /**
     * @Post(
     *     operationId="create-verification",
     *     @RequestBody(
     *          @MediaType(
     *              mediaType="application/json",
     *              @Schema(ref=@Model(type=CreateVerificationRequest::class))
     *          )
     *     )
     * )
     *
     * @Response(
     *     @JsonContent(ref=@Model(type=VerificationCreated::class)),
     *     response=201,
     *     description="Verification created."
     * )
     *
     * @Response(
     *     response=400,
     *     description="Malformed JSON passed.",
     * )
     *
     * @Response(
     *     response=409,
     *     description="Duplicated verification..",
     * )
     *
     * @Response(
     *     response=500,
     *     description="Internal server errors",
     * )
     *
     * @Response(
     *     response=422,
     *     description="Validation failed: invalid / missing variables supplied.",
     * )
     */
    public function create(CreateVerificationRequest $request): VerificationCreated
    {
        return new VerificationCreated('123');
    }
}