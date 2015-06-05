<?php

namespace IMAG\LdapBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Component\Config\FileLocator;

class IMAGLdapExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XMLFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security_ldap.xml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        foreach($config['connection'] as $k => $v)
        {
            $container->setParameter('imag_ldap.ldap_connection.'.$k, $v);
        }
        $container->setParameter('imag_ldap.ldap_connection.params', $config['connection'] ['default']);
        $container->setParameter('imag_ldap.authentication.bind_username_before', $config['connection'] ['default'] ['client'] ['bind_username_before']);
        $container->setParameter('imag_ldap.model.user_class', $config["user_class"]);
    }

    public function getAlias()
    {
        return "imag_ldap";
    }
}
