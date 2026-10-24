<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Closure\ClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\Function_\AddFunctionVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddReturnTypeDeclarationFromYieldsRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

// use RectorLaravel\Set\LaravelSetProvider;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSkip([
        __DIR__.'/bootstrap/cache',
        __DIR__.'/storage',
        __DIR__.'/vendor',
    ])
    ->withComposerBased(laravel: true)
    ->withImportNames()
    ->withAttributesSets()
    ->withPhpSets()
    ->withRules([
        DeclareStrictTypesRector::class,
        ReturnTypeFromStrictTypedPropertyRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        AddReturnTypeDeclarationFromYieldsRector::class,
        AddClosureVoidReturnTypeWhereNoReturnRector::class,
        ClosureReturnTypeRector::class,
        AddReturnTypeDeclarationRector::class,
        AddFunctionVoidReturnTypeWhereNoReturnRector::class,
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);
