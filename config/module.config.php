<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

return array(

    'doctrine_mongoodm_module' => array(
        // Use following setting if you know where your 'DoctrineAnnotations.php' is
        //'annotation_file' => __DIR__ . '/../vendor/mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php',
        'use_annotations' => true,
    ),

    'di' => array(
        'definition' => array(
            'class' => array(
                'Memcache' => array(
                    'addServer' => array(
                        'host' => array('type' => false, 'required' => true),
                        'port' => array('type' => false, 'required' => true),
                    )
                ),
                'DoctrineMongoODMModule\Factory\DocumentManager' => array(
                    'instantiator' => array('DoctrineMongoODMModule\Factory\DocumentManager', 'get'),
                    'methods' => array(
                        'get' => array(
                            'conn' => array('type' => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection', 'required' => true)
                        ),
                    ),
                ),
            ),
        ),
        'instance' => array(
            'alias' => array(
                // document manager
                'mongo_dm'           => 'Doctrine\ODM\MongoDB\DocumentManager',

                // configuration
                'mongo_config'       => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Configuration',
                'mongo_connection'   => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection',
                'mongo_driver_chain' => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\DriverChain',
                'mongo_evm'          => 'DoctrineModule\Doctrine\Common\EventManager',
            ),

            // Setting defaults: allows implicit injection of mongo_dm and mongo_connection when their types
            // are requested
            'preference' => array(
                'Doctrine\ODM\MongoDB\DocumentManager' => 'mongo_dm',
                'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection' => 'mongo_connection',
            ),

            'mongo_dm' => array(
                'parameters' => array(
                    'conn' => 'mongo_connection',
                ),
            ),

            'mongo_evm' => array(
                'parameters' => array(
                    'opts' => array(
                        'subscribers' => array(),
                    ),
                ),
            ),

            'mongo_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(),
                    'cache' => 'doctrine_cache_array',
                ),
            ),

            'mongo_connection' => array(
                'parameters' => array(
                    'server'  => null,
                    'options' => array(),
                    'config'  => 'mongo_config',
                    'evm'     => 'mongo_evm',
                )
            ),

            'mongo_config' => array(
                'parameters' => array(
                    'opts' => array(
                        'auto_generate_proxies'   => true,
                        'proxy_dir'               => __DIR__ . '/../../../data/DoctrineMongoODMModule/Proxy',
                        'proxy_namespace'         => 'DoctrineMongoODMModule\Proxy',
                        'auto_generate_hydrators' => true,
                        'hydrator_dir'            => __DIR__ . '/../../../data/DoctrineMongoODMModule/Hydrators',
                        'hydrator_namespace'      => 'DoctrineMongoODMModule\Hydrators',
                    ),
                    'metadataDriver' => 'mongo_driver_chain',
                    'metadataCache'  => 'doctrine_cache_array',
                    'logger'         => null,
                ),
            ),

            'DoctrineModule\Authentication\Adapter\DoctrineObject' => array(
                'parameters' => array(
                    'objectManager' => 'mongo_dm',
                ),
            ),

            // Commands to be attached to CLI tools
            'doctrine_cli' => array(
                'injections' => array(
                    // MongoDB ODM
                    'Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand',
                    'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand',
                    'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand',
                    'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand',
                    'Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand',
                    'Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand',
                    'Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand',
                ),
            ),

            // CLI helpers
            'doctrine_cli_helperset' => array(
                'injections' => array(
                    'set' => array(
                        array(
                            'helper' => 'Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper',
                            'alias' => 'dm'
                        ),
                    ),
                ),
            ),
        ),

        'definition' => array(
            'class' => array(
                'Memcache' => array(
                    'addServer' => array(
                        'host' => array(
                            'type' => false,
                            'required' => true,
                        ),
                        'port' => array(
                            'type' => false,
                            'required' => true,
                        ),
                    )
                ),
                'Doctrine\ODM\MongoDB\DocumentManager' => array(
                    'instantiator' => array(
                        'DoctrineMongoODMModule\Factory\DocumentManager',
                        'get'
                    ),
                ),
                'DoctrineMongoODMModule\Factory\DocumentManager' => array(
                    'methods' => array(
                        'get' => array(
                            'conn' => array(
                                'type' => 'DoctrineMongoODMModule\Doctrine\ODM\MongoDB\Connection',
                                'required' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);