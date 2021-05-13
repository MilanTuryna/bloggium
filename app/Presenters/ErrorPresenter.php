<?php


namespace App\Presenters;


use Nette\Application\BadRequestException;
use Nette\Application\IPresenter;
use Nette\Application\Response;
use Nette\Application\Request;
use Nette\SmartObject;
use Tracy\ILogger;
use Nette;

/**
 * Class ErrorPresenter
 * @package App\Presenters
 */
final class ErrorPresenter implements IPresenter
{
    use SmartObject;

    private ILogger $logger;

    /**
     * Error4xxPresenter constructor.
     * @param ILogger $logger
     */
    public function __construct(ILogger $logger)
    {
        $this->logger = $logger;
    }

    public function run(Request $request): Response {
        $exception = $request->getParameter('exception');
        if($exception instanceof BadRequestException) {
            [$module, , $separator] = Nette\Application\Helpers::splitName($request->getPresenterName());
            return new Responses\ForwardResponse($request->setPresenterName($module . $separator. 'Error4xx'));
        }

        $this->logger->log($exception, ILogger::EXCEPTION);
        return new Nette\Application\Responses\CallbackResponse(function (Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse): void {

        });
    }
}