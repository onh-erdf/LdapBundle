<?php

namespace IMAG\LdapBundle\Encoder;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Created by PhpStorm.
 * User: i74375
 * Date: 30/09/2015
 * Time: 15:14
 */
class LdapPasswordEncoder extends BasePasswordEncoder{

    /**
     * {@inheritdoc}
     */
    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }

        return $this->mergePasswordAndSalt($raw, $salt);
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            return false;
        }

        if (null === $raw) {
            throw new BadCredentialsException('Password not set.');
        }

        $pass2 = $this->mergePasswordAndSalt($raw, $salt);

        return $this->comparePasswords($encoded, $pass2);

    }
}