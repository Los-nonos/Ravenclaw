<?php


namespace Presentation\Http\Adapters\Admins;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Admins\ShowAdminByIdQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Admin\ShowAdminByIdSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class ShowAdminByIdAdapter
{
    private ValidatorServiceInterface $validatorService;

    private ShowAdminByIdSchema $schema;

    public function __construct(ValidatorServiceInterface $validatorService, ShowAdminByIdSchema $schema)
    {
        $this->validatorService = $validatorService;
        $this->schema = $schema;
    }

    /**
     * @param Request $request
     * @return ShowAdminByIdQuery
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validatorService->make($request->all(), $this->schema->getRules());

        if($this->validatorService->isFail())
        {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }

        return new ShowAdminByIdQuery($request->query('id'));
    }
}
