<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Link\StoreRequest;
use App\Manager\LinkManagerInterface;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LinkController extends Controller
{
    private LinkManagerInterface $linkManager;

    public function __construct(LinkManagerInterface $linkManager)
    {
        $this->linkManager = $linkManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $links = $user->links()->paginate(self::paginate());

        return $this->send('', $links->toArray(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $token = $this->linkManager->generateToken();

        while ($this->linkManager->isTokenExist($token)) {
            $token = $this->linkManager->generateToken();
        }

        $data = [
            'address' => $request->get('address'),
            'token' => $token,
        ];

        $link = $user->links()->create($data);

        if (!$link->save()) {
            return $this->internalError();
        }

        return $this->send(__('link.generated'), $link->toArray(), Response::HTTP_CREATED);
    }

    /**
     * @param string $locale
     * @param string $token
     * @return JsonResponse
     */
    public function show(string $locale, string $token): JsonResponse
    {
        $link = Link::where('token', $token)->first();

        if (null === $link) {
            return $this->notFound();
        }

        return $this->send('', $link->toArray(), Response::HTTP_OK);
    }

    /**
     * @param string $locale
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(string $locale, int $id): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $link = Link::find($id);

        if (null === $link) {
            return $this->notFound();
        }

        if ($user->cannot('delete', $link)) {
            return $this->unAuthorized();
        }

        $link->delete();

        return $this->send(__('link.deleted'), [], Response::HTTP_OK);
    }
}
