<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoInterface;
use ContatoModulo\Aplicacao\Excel\LeitorArquivoContatos;
use ContatoModulo\Modelo\Contato;
use Doctrine\ORM\EntityManager;
use Zend\Diactoros\UploadedFile;

/**
 * Class ImportarContatosServico
 *
 * @package ContatoModulo\Aplicacao\Contato
 */
class ImportarContatosServico
{
    /**
     * @var LeitorArquivoContatos
     */
    private $leitor;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var AutenticacaoInterface
     */
    private $autenticacao;

    /**
     * ImportarContatosServico constructor.
     *
     * @param LeitorArquivoContatos $leitorArquivoContatos
     * @param EntityManager $entityManager
     * @param AutenticacaoInterface $autenticacao
     */
    public function __construct(
        LeitorArquivoContatos $leitorArquivoContatos,
        EntityManager $entityManager,
        AutenticacaoInterface $autenticacao
    ) {
        $this->leitor = $leitorArquivoContatos;
        $this->em = $entityManager;
        $this->autenticacao = $autenticacao;
    }

    /**
     * @param UploadedFile $arquivo
     * @param string $token
     * @return bool
     */
    public function importarContatos(UploadedFile $arquivo, string $token): bool
    {
        $usuario = $this->autenticacao->obterUsuarioAutenticado($token);

        $dados = $this->leitor->getConteudo((string)$arquivo->getStream());

        foreach ($dados as $d) {
            $contato = new Contato();
            $contato->setNome($d['nome'])
                ->setSetor($d['setor'])
                ->setRamalOuTelefone($d['ramalOuTelefone'])
                ->setUsuario($usuario);

            $this->em->persist($contato);
        }

        $this->em->flush();

        return true;
    }
}
