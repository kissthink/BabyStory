<?php

namespace Richpolis\HistoriasBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ComentarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ComentarioRepository extends EntityRepository
{
    public function queryFindComentarios($buscar = "")
    {
        $em = $this->getEntityManager();
        if(strlen($buscar)==0){
            $consulta = $em->createQuery('SELECT c,u,h '
                . 'FROM HistoriasBundle:Comentario c '
                . 'JOIN c.usuario u '    
                . 'JOIN c.historia h '    
                . 'ORDER BY c.createdAt ASC, u.username ASC');
        }else{
            $consulta = $em->createQuery("SELECT c,u,h "
                . "FROM HistoriasBundle:Comentario c "
                . "JOIN c.usuario u "
                . "JOIN c.historia h "
                . "WHERE c.comentario LIKE :comentario OR u.username LIKE :username OR h.historia LIKE :historia  "
                . "ORDER BY c.createdAt ASC, u.username ASC");
            $consulta->setParameters(array(
                'comentario' => "%".$buscar."%",
                'username' => "%".$buscar."%",
                'historia' => "%".$buscar."%"
            ));
        }
        return $consulta;
    }
    
    public function findComentarios($buscar = ""){
        return $this->queryFindComentarios($buscar)->getResult();
    }
}
