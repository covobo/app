<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle\Controller;

use OpenApi\Annotations\Post;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\PathParameter;
use OpenApi\Annotations\Put;
use Nelmio\ApiDocBundle\Annotation\Model;
use SunFinanceGroup\Notificator\Verification\BadVerificationCode;
use SunFinanceGroup\Notificator\Verification\Exception\NoPermission;
use SunFinanceGroup\Notificator\Verification\Exception\VerificationExpired;
use SunFinanceGroup\Notificator\Verification\Exception\VerificationIsAlreadyConfirmed;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\ConfirmVerificationRequest;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\CreateVerificationRequest;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\VerificationCreated;
use SunFinanceGroup\Notificator\VerificationBundle\VerifierInterface;
use SunFinanceGroup\Notificator\VerificationService\Exception\VerificationNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

// TODO: there must be some kind of lock to prevent concurrency of creating verification for a single identity
final class VerificationController
{
    public function __construct(private VerifierInterface $verifier)
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
     *     description="Duplicated verification.",
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
    public function create(Request $httpRequest, CreateVerificationRequest $request): VerificationCreated
    {
        return $this->verifier->create(
            $request,
            $httpRequest->getClientIp(),
            $httpRequest->headers->get('User-Agent')
        );
    }

    /**
     * @Put(
     *     operationId="confirm-verification",
     *     @RequestBody(
     *          @MediaType(
     *              mediaType="application/json",
     *              @Schema(ref=@Model(type=ConfirmVerificationRequest::class))
     *          )
     *     )
     * )
     *
     * @PathParameter(
     *     name="uuid",
     *     description="Verification uuid",
     *     @Schema(type="string")
     * )
     *
     * @Response(
     *     response=204,
     *     description="Verification confirmed."
     * )
     *
     * @Response(
     *     response=400,
     *     description="Malformed JSON passed.",
     * )
     *
     * @Response(
     *     response=403,
     *     description="No permission to confirm verification.",
     * )
     *
     * @Response(
     *     response=404,
     *     description="Verification not found.",
     * )
     *
     * @Response(
     *     response=410,
     *     description="Verification expired.",
     * )
     *
     * @Response(
     *     response=422,
     *     description="Validation failed: invalid code supplied.",
     * )
     *
     * @Response(
     *     response=500,
     *     description="Internal server errors",
     * )
     */
    public function confirm(string $uuid, ConfirmVerificationRequest $request, Request $httpRequest): HTTPResponse
    {
        try {
            $this->verifier->confirm($uuid, $request->getCode(), $httpRequest->getClientIp(), $httpRequest->headers->get('User-Agent'));
        } catch (VerificationIsAlreadyConfirmed $e) {
            return new HTTPResponse('', HTTPResponse::HTTP_NO_CONTENT);
        } catch (VerificationNotFoundException $e) {
            return new HTTPResponse('', HTTPResponse::HTTP_NOT_FOUND);
        } catch (VerificationExpired $e) {
            return new HTTPResponse('', HTTPResponse::HTTP_GONE);
        } catch (BadVerificationCode $e) {
            return new HTTPResponse('', HTTPResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (NoPermission $e) {
            return new HTTPResponse('', HTTPResponse::HTTP_FORBIDDEN);
        }

        return new HTTPResponse('', HTTPResponse::HTTP_NO_CONTENT);
    }
}