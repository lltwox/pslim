<?php
namespace PSlim;

use PSlim\Exception;
use PSlim\Service\PathRegistry;
use PSlim\Service\NameParser;
use PSlim\Service\InstanceStorage;
use PSlim\Service\LibraryStorage;
use PSlim\Service\SymbolStorage;
use PSlim\Service\TypeConverter;
use PSlim\Service\SutRegistry;

/**
 * Service locator pattern implementation.
 * Registry of service instances.
 *
 * @author lltwox <lltwox@gmail.com>
 *
 */
class ServiceLocator {

    /**
     * One instance of service locator, that can be created.
     *
     * @var ServiceLocator
     */
    private static $instance = null;

    /**
     * Instance of path registry object
     *
     * @var PathRegistry
     */
    private $pathRegistry = null;

    /**
     * Instance of name parser object
     *
     * @var NameParser
     */
    private $nameParser = null;

    /**
     * Storage, for instances, created with make instruction
     *
     * @var InstanceStorage
     */
    private $instanceStorage = null;

    /**
     * Storage, for special library objects, created with make instruction
     *
     * @var LibraryStorage
     */
    private $libraryStorage = null;

    /**
     * Storage, for symbol values, created with callAndAssign instruction
     *
     * @var SymbolStorage
     */
    private $symbolStorage = null;

    /**
     * Type converter object
     *
     * @var TypeConverter
     */
    private $typeConverter = null;

    /**
     * Sut registry object
     *
     * @var SutRegistry
     */
    private $sutRegistry = null;

    /**
     * Init instance of service locator.
     *
     * This ensures, that only one instance of service locator can be created
     * and it will be created by PSlim in the begging.
     *
     * @return ServiceLocator
     */
    public static function initInstance() {
        if (null !== self::$instance) {
            throw new Exception(
                'Only one instance of ServiceLocator can be created'
            );
        }

        self::$instance = new ServiceLocator();
        ServiceLocatorUser::setServiceLocator(self::$instance);

        return self::$instance;
    }

    /**
     * Private constructor to enforce use of initialization method
     *
     */
    private function __construct() {
    }

    /**
     * Get path registry, containing all imported paths
     *
     * @return PathRegistry
     */
    public function getPathRegistry() {
        if (null == $this->pathRegistry) {
            $this->pathRegistry = new PathRegistry();
        }

        return $this->pathRegistry;
    }

    /**
     * Get name parser object, that can convert names of path and classes
     * in FitNesse notation to currently selected php notation.
     * By default PEAR notation is selected.
     *
     * @return NameParser
     */
    public function getNameParser() {
        if (null == $this->nameParser) {
            $this->nameParser = new NameParser\Pear();
        }

        return $this->nameParser;
    }

    /**
     * Set name parser object
     *
     * @param NameParser $nameParser
     */
    public function setNameParser(NameParser $nameParser) {
        $this->nameParser = $nameParser;
    }

    /**
     * Get instance storage object, that can store named objects.
     * Used for storing objects, created with make instruction.
     *
     * @return InstanceStorage
     */
    public function getInstanceStorage() {
        if (null == $this->instanceStorage) {
            $this->instanceStorage = new InstanceStorage();
        }

        return $this->instanceStorage;
    }

    /**
     * Get library storage object, that can store named objects.
     * Used for storing special library objects.
     *
     * @return InstanceStorage
     */
    public function getLibraryStorage() {
        if (null == $this->libraryStorage) {
            $this->libraryStorage = new LibraryStorage();
        }

        return $this->libraryStorage;
    }

    /**
     * Get symbol storage object, that can store named values.
     * Used for storing values, created with callAndAssign instruction.
     *
     * @return SymbolStorage
     */
    public function getSymbolStorage() {
        if (null == $this->symbolStorage) {
            $this->symbolStorage = new SymbolStorage();
        }

        return $this->symbolStorage;
    }

    /**
     * Get type converter object, that can convert strings to object of some
     * type or from object to string
     *
     * @return TypeConverter
     */
    public function getTypeConverter() {
        if (null == $this->typeConverter) {
            $this->typeConverter = new TypeConverter();
        }

        return $this->typeConverter;
    }

    /**
     * Get sut registry object, that can retrieve sut objects from fixtures.
     *
     * @return SutStorage
     */
    public function getSutRegistry() {
        if (null == $this->sutRegistry) {
            $this->sutRegistry = new SutRegistry();
        }

        return $this->sutRegistry;
    }

}