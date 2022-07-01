<?php

declare(strict_types=1);

namespace Rector\CodeQuality\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Type\Type;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersion;
use Rector\TypeDeclaration\NodeAnalyzer\ReturnTypeAnalyzer\StrictScalarReturnTypeAnalyzer;
use Rector\VersionBonding\Contract\MinPhpVersionInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\CodeQuality\Rector\ClassMethod\ReturnTypeFromStrictScalarReturnExprRector\ReturnTypeFromStrictScalarReturnExprRectorTest
 */
final class ReturnTypeFromStrictScalarReturnExprRector extends AbstractRector implements MinPhpVersionInterface
{
    public function __construct(
        private readonly StrictScalarReturnTypeAnalyzer $strictScalarReturnTypeAnalyzer
    ) {
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change return type based on strict scalar returns - string, int, float or bool', [
            new CodeSample(
                <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($value)
    {
        if ($value) {
            return 'yes';
        }

        return 'no';
    }
}
CODE_SAMPLE

                ,
                <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($value): string
    {
        if ($value) {
            return 'yes';
        }

        return 'no';
    }
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class, Function_::class, Closure::class];
    }

    /**
     * @param ClassMethod|Function_|Closure $node
     */
    public function refactor(Node $node): ?Node
    {
        if ($node->returnType !== null) {
            return null;
        }

        $scalarReturnType = $this->strictScalarReturnTypeAnalyzer->matchAlwaysScalarReturnType($node);
        if (! $scalarReturnType instanceof Type) {
            return null;
        }

        dump($scalarReturnType);
        die;
    }

    public function provideMinPhpVersion(): int
    {
        return PhpVersion::PHP_70;
    }
}
