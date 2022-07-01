<?php

declare(strict_types=1);

namespace Rector\TypeDeclaration\TypeAnalyzer;

use PhpParser\Node\Expr;

final class AlwaysStrictScalarExprAnalyzer
{
    public function isStrictScalarExpr(Expr $expr): bool
    {
        dump($expr);
        die;
    }
}
