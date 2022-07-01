<?php

declare(strict_types=1);

namespace Rector\TypeDeclaration\NodeAnalyzer\ReturnTypeAnalyzer;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Type\Type;
use Rector\TypeDeclaration\TypeAnalyzer\AlwaysStrictBoolExprAnalyzer;

final class StrictScalarReturnTypeAnalyzer
{
    public function __construct(
        private readonly AlwaysStrictReturnAnalyzer $alwaysStrictReturnAnalyzer,
        private readonly AlwaysStrictBoolExprAnalyzer $alwaysStrictBoolExprAnalyzer,
    ) {
    }

    public function matchAlwaysScalarReturnType(ClassMethod|Closure|Function_ $functionLike): ?Type
    {
        $returns = $this->alwaysStrictReturnAnalyzer->matchAlwaysStrictReturns($functionLike);
        if ($returns === null) {
            return null;
        }

        foreach ($returns as $return) {
            // we need exact expr return
            if (! $return->expr instanceof Expr) {
                return null;
            }

            dump($return->expr);
            die;

            if (! $this->alwaysStrictBoolExprAnalyzer->isStrictBoolExpr($return->expr)) {
                return false;
            }
        }

        return true;
    }
}
