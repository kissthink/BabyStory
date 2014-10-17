<?php

namespace Richpolis\HistoriasBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Richpolis\UsuariosBundle\Entity\Usuario;

/**
 * HistoriaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HistoriaRepository extends EntityRepository
{
    
    
    public function queryFindHistorias($buscar = "",$usuario=null)
    {
        $em = $this->getEntityManager();
        if(strlen($buscar)==0){
            if($usuario == null){
                $consulta = $em->createQuery('SELECT h '
                    . 'FROM HistoriasBundle:Historia h '
                    . 'ORDER BY h.fecha ASC');
            }else{
                $consulta = $em->createQuery("SELECT h "
                    . "FROM HistoriasBundle:Historia h "
                    . "WHERE h.usuario=:usuario  "    
                    . "ORDER BY h.historia ASC");
                $consulta->setParameters(array(
                    'usuario' => $usuario->getId(),
                ));
            }
        }else{
            if($usuario == null){
                $consulta = $em->createQuery("SELECT h "
                    . "FROM HistoriasBundle:Historia h "
                    . "WHERE h.historia LIKE :historia  "    
                    . "ORDER BY h.historia ASC");
                $consulta->setParameters(array(
                    'historia' => "%".$buscar."%",
                ));
            }else{
                $consulta = $em->createQuery("SELECT h "
                    . "FROM HistoriasBundle:Historia h "   
                    . "WHERE h.historia LIKE :historia  "
                    . "AND h.usuario=:usuario  "    
                    . "ORDER BY h.historia ASC");
                $consulta->setParameters(array(
                    'historia' => "%".$buscar."%",
                    'usuario' => $usuario->getId(),
                ));
            }
        }
        return $consulta;
    }
    
    public function findHistorias($buscar = "",$usuario=null){
        return $this->queryFindHistorias($buscar,$usuario)->getResult();
    }
    
    public function getCountHistoriasEnYears($year, Usuario $usuario)
    {
        $em = $this->getEntityManager();
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
            $consulta = $em->createQuery(
                "SELECT DISTINCT MONTH(h.fecha) as mes, YEAR(h.fecha) as year, a.imagen as imagen "
                . "FROM HistoriasBundle:Historia h "
                . "JOIN h.usuario u "
                . "JOIN h.hijo a "    
                . "WHERE u.id=:usuario "    
                . "ORDER BY h.createdAt DESC");
            $consulta->setParameters(array(
                'usuario'   =>  $usuario->getId(),
            ));
        return $consulta->getResult();
    }
    
    public function getHistoriasDelMes($year,$mes, Usuario $usuario)
    {
        $em = $this->getEntityManager();
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
            $consulta = $em->createQuery(
                "SELECT h, c, u, uh "
                . "FROM HistoriasBundle:Historia h "
                . "JOIN h.componentes c "
                . "JOIN h.usuario u "
                . "JOIN u.hijos uh "
                . "WHERE YEAR(h.fecha) =:year "
                . "AND MONTH(h.fecha)=:mes "
                . "AND u.id=:usuario "    
                . "ORDER BY h.fecha DESC");
            $consulta->setParameters(array(
                'year'  =>  $year,
                'mes'   =>  $mes,
                'usuario'   =>  $usuario->getId(),
            ));
        return $consulta->getResult();
    }
}
