<?php
/**
 * Created by PhpStorm.
 * User: stas.pivchenko
 * Date: 12/3/18
 * Time: 2:53 AM
 */

namespace App\Model;


use App\Entity\User;

class UserManager
{

    /**
     * {@inheritdoc}
     */
    public function findUserByConfirmationToken($token)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        return $this->findUserBy(array('confirmationToken' => $token));
    }
}