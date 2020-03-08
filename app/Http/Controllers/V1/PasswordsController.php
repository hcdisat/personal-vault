<?php namespace App\Http\Controllers\V1;

use App\Core\Repositories\DbPasswordRepository;
use App\Core\Repositories\Transformers\PasswordTransformer;
use App\Http\Controllers\ApiController;
use App\Http\RoutesInfo\V1\PasswordInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordsController extends ApiController
{
    /**
     * @var DbPasswordRepository
     */
    private DbPasswordRepository $passwords;

    /**
     * @var PasswordTransformer
     */
    private PasswordTransformer $transformer;

    public function __construct(DbPasswordRepository $passwords, PasswordTransformer $transformer)
    {
        parent::__construct();
        $this->transformer = $transformer;
        $this->passwords = $passwords;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->ok(
           $this->transformer
               ->transformMany( $this->passwords->all())
        );
    }

    /**
     * @param int $passwordId
     * @return JsonResponse
     */
    public function show(int $passwordId): JsonResponse
    {
        $password = $this->passwords->findById($passwordId);

        return $password !== null
            ? response()->ok($this->transformer->transform($password))
            : response()->notFound('Resource was not found.');
    }

    /**
     * @param Request $request
     * @param int $passwordId
     * @return JsonResponse
     */
    public function update(Request $request, int $passwordId): JsonResponse
    {
        if (! $password = $this->passwords->findById($passwordId)) {
            return response()->notFound('Password does not exists');
        }

        $data = $request->only($this->getDataFields());

        if ($this->passwords->update($password, $data)) {
            return response()->ok(
                $this->transformer->transform($password),
                'Password was updated'
            );
        }

        return response()->badRequest('Password not updated');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->only($this->getDataFields());

        $password = $this->passwords->create($data);

        return response()->created(
            $this->transformer->transform($password),
            'created'
        );
    }

    /**
     * @param int $passwordId
     * @return JsonResponse
     */
    public function destroy(int $passwordId): JsonResponse
    {
        return $this->passwords->destroy($passwordId) > 0
            ? response()->noContentJson()
            : response()->notFound('Resource was not found.');
    }

    /**
     * @return array
     */
    protected function getDataFields(): array
    {
        return [
            PasswordInfo::Name,
            PasswordInfo::Value,
            PasswordInfo::Username,
            PasswordInfo::Website,
            PasswordInfo::Note
        ];
    }
}
