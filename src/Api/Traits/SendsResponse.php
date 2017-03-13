<?php

namespace Api\Traits;

use Illuminate\Http\Response;
use Spatie\Fractal\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

trait SendsResponse
{
    /**
     * Default status code.
     *
     * @var int
     */
    private $status = Response::HTTP_OK;

    /**
     * Set a status code.
     *
     * @param $status
     *
     * @return $this
     */
    public function setStatusCode($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get a status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    /**
     * Return response to client.
     *
     * @param $content
     * @param array $headers
     * @return mixed
     */
    public function response($content, $headers = [])
    {
        return response()->json($content, $this->getStatusCode(), $headers);
    }

    /**
     * Respond with a transformed collection
     *
     * @param $collection
     * @param $transformer
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithCollection($collection, $transformer, $message = 'OK')
    {
        $data = Fractal::create()
            ->collection($collection, $transformer)
            ->paginateWith(new IlluminatePaginatorAdapter($collection))
            ->toArray();

        return $this->response($data, [
            'message' => $message,
            'code' => $this->getStatusCode()
        ]);
    }

    /**
     * Respond with a single item
     *
     * @param $item
     * @param $transformer
     * @param string $message
     * @return mixed
     */
    public function respondWithItem($item, $transformer, $message = 'OK')
    {
        $data = Fractal::create()->item($item, $transformer)->toArray();

        return $this->response($data, [
            'message' => $message,
            'code' => $this->getStatusCode()
        ]);
    }

    /**
     * Return error response.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondWithError($message = 'An error occurred while performing the operation')
    {
        return $this->response([
            'error' => [
                'message' => $message,
                'code'    => $this->getStatusCode(),
            ],
        ]);
    }

    /**
     * Return when request is successful.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondWithSuccess($message = 'Ok')
    {
        return $this->response([
            'message' => $message,
            'code'    => $this->getStatusCode(),
        ]);
    }

    /**
     * Respond when validation fails.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondValidationFails($message = 'Unprocessable entity')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithError($message);
    }

    /**
     * Respond when resource is created.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondCreated($message = 'Resource created')
    {
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respondWithSuccess($message);
    }

    /**
     * Respond when resource is updated.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondUpdated($message = 'Resource updated')
    {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respondWithSuccess($message);
    }

    /**
     * Respond when resource is not found.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    /**
     * Respond if there is an internal error when handling request.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondInternalServerError($message = 'Internal server error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message);
    }
}
