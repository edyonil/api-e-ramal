<?php
declare(strict_types=1);

namespace ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Contato\ContatoService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ContatoAcaoFactory
 *
 * @package ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class ContatoAcaoFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return mixed
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new $requestedName($container->get(ContatoService::class));
    }
}
