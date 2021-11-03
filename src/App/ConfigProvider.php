<?php declare(strict_types=1);

namespace App;

use App\Hydrator\ClassMethodsHydratorFactory;
use Envms\FluentPDO\Query;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Mezzio\Template\TemplateRendererInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            ConfigAbstractFactory::class => $this->getAbstractFactoryConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class,
                Rating\ProjectRatingCalculator::class,
                Validator\Input\UsernameInput::class,
                Validator\Input\PasswordInput::class,
                Validator\Input\EmailInput::class,
            ],
            'factories' => [
                ClassMethodsHydrator::class => ClassMethodsHydratorFactory::class,

                Handler\EventHandler::class => ConfigAbstractFactory::class,
                Handler\EventAboutHandler::class => ConfigAbstractFactory::class,
                Handler\EventListHandler::class => ConfigAbstractFactory::class,
                Handler\IndexHandler::class => ConfigAbstractFactory::class,
                Handler\ProjectHandler::class => ConfigAbstractFactory::class,
                Handler\TopicHandler::class => ConfigAbstractFactory::class,
                Handler\TopicSubmitHandler::class => ConfigAbstractFactory::class,
                Handler\UserHandler::class => ConfigAbstractFactory::class,

                Middleware\EventParticipantMiddleware::class => ConfigAbstractFactory::class,
                Middleware\EventMiddleware::class => ConfigAbstractFactory::class,
                Middleware\EventListMiddleware::class => ConfigAbstractFactory::class,
                Middleware\EventRatingReleasedMiddleware::class => ConfigAbstractFactory::class,
                Middleware\ParticipantProjectMiddleware::class => ConfigAbstractFactory::class,
                Middleware\ProjectCategoryRatingMiddleware::class => ConfigAbstractFactory::class,
                Middleware\ProjectEventRatingReleasedMiddleware::class => ConfigAbstractFactory::class,
                Middleware\ProjectMiddleware::class => ConfigAbstractFactory::class,
                Middleware\ProjectOwnerMiddleware::class => ConfigAbstractFactory::class,
                Middleware\ProjectParticipantMiddleware::class => ConfigAbstractFactory::class,
                Middleware\TemplateDefaultsMiddleware::class => ConfigAbstractFactory::class,
                Middleware\TopicEntryStatisticMiddleware::class => ConfigAbstractFactory::class,
                Middleware\TopicSubmitMiddleware::class => ConfigAbstractFactory::class,
                Middleware\UserMiddleware::class => ConfigAbstractFactory::class,

                Service\EventRatingCategoryService::class => ConfigAbstractFactory::class,
                Service\EventRatingService::class => ConfigAbstractFactory::class,
                Service\EventService::class => ConfigAbstractFactory::class,
                Service\ParticipantService::class => ConfigAbstractFactory::class,
                Service\ProjectService::class => ConfigAbstractFactory::class,
                Service\RatingCategoryService::class => ConfigAbstractFactory::class,
                Service\RatingService::class => ConfigAbstractFactory::class,
                Service\RoleService::class => ConfigAbstractFactory::class,
                Service\TopicPoolService::class => ConfigAbstractFactory::class,
                Service\UserService::class => ConfigAbstractFactory::class,

                Table\EventRatingCategoryTable::class => ConfigAbstractFactory::class,
                Table\EventRatingTable::class => ConfigAbstractFactory::class,
                Table\EventTable::class => ConfigAbstractFactory::class,
                Table\ParticipantTable::class => ConfigAbstractFactory::class,
                Table\ProjectTable::class => ConfigAbstractFactory::class,
                Table\RatingCategoryTable::class => ConfigAbstractFactory::class,
                Table\RatingTable::class => ConfigAbstractFactory::class,
                Table\RoleTable::class => ConfigAbstractFactory::class,
                Table\TopicPoolTable::class => ConfigAbstractFactory::class,
                Table\UserTable::class => ConfigAbstractFactory::class,
            ],
        ];
    }

    public function getAbstractFactoryConfig(): array
    {
        return [
            Handler\EventHandler::class => [
                ClassMethodsHydrator::class,
                TemplateRendererInterface::class,
            ],
            Handler\EventAboutHandler::class => [
                TemplateRendererInterface::class,
            ],
            Handler\EventListHandler::class => [
                TemplateRendererInterface::class,
            ],
            Handler\IndexHandler::class => [
                TemplateRendererInterface::class,
            ],
            Handler\ProjectHandler::class => [
                ClassMethodsHydrator::class,
                TemplateRendererInterface::class,
            ],
            Handler\TopicHandler::class => [
                TemplateRendererInterface::class,
            ],
            Handler\TopicSubmitHandler::class => [
                TemplateRendererInterface::class,
            ],
            Handler\UserHandler::class => [
                ClassMethodsHydrator::class,
                TemplateRendererInterface::class,
            ],
            Middleware\EventListMiddleware::class => [
                Service\EventService::class,
            ],
            Middleware\EventMiddleware::class => [
                Service\EventService::class,
            ],
            Middleware\EventParticipantMiddleware::class => [
                Service\ParticipantService::class,
            ],
            Middleware\EventRatingReleasedMiddleware::class => [
                Service\EventService::class,
            ],
            Middleware\ParticipantProjectMiddleware::class => [
                Service\ProjectService::class,
                Service\UserService::class,
            ],
            Middleware\ProjectCategoryRatingMiddleware::class => [
                Service\RatingService::class,
                Rating\ProjectRatingCalculator::class,
            ],
            Middleware\ProjectEventRatingReleasedMiddleware::class => [
                Service\EventService::class,
            ],
            Middleware\ProjectMiddleware::class => [
                Service\ProjectService::class,
            ],
            Middleware\ProjectOwnerMiddleware::class => [
                Service\UserService::class,
            ],
            Middleware\ProjectParticipantMiddleware::class => [
                Service\ParticipantService::class,
            ],
            Middleware\TemplateDefaultsMiddleware::class => [
                TemplateRendererInterface::class,
            ],
            Middleware\TopicEntryStatisticMiddleware::class => [
                Service\TopicPoolService::class,
            ],
            Middleware\TopicSubmitMiddleware::class => [
                Service\TopicPoolService::class,
                ClassMethodsHydrator::class,
            ],
            Middleware\UserMiddleware::class => [
                Service\UserService::class,
            ],
            Service\EventRatingCategoryService::class => [
                Table\EventRatingCategoryTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\EventRatingService::class => [
                Table\EventRatingTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\EventService::class => [
                Table\EventTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\ProjectService::class => [
                Table\ProjectTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\ParticipantService::class => [
                Table\ParticipantTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\RatingCategoryService::class => [
                Table\RatingCategoryTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\RatingService::class => [
                Table\RatingTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\RoleService::class => [
                Table\RoleTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\TopicPoolService::class => [
                Table\TopicPoolTable::class,
                ClassMethodsHydrator::class,
            ],
            Service\UserService::class => [
                Table\UserTable::class,
                ClassMethodsHydrator::class,
            ],
            Table\EventRatingCategoryTable::class => [
                Query::class,
            ],
            Table\EventRatingTable::class => [
                Query::class,
            ],
            Table\EventTable::class => [
                Query::class,
            ],
            Table\ParticipantTable::class => [
                Query::class,
            ],
            Table\ProjectTable::class => [
                Query::class,
            ],
            Table\RatingCategoryTable::class => [
                Query::class,
            ],
            Table\RatingTable::class => [
                Query::class,
            ],
            Table\RoleTable::class => [
                Query::class,
            ],
            Table\TopicPoolTable::class => [
                Query::class,
            ],
            Table\UserTable::class => [
                Query::class,
            ],
        ];
    }
}
