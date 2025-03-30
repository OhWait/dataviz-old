<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\TokenType;

class SimilarityFunction extends FunctionNode
{
    public $firstString = null;
    public $secondString = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'SIMILARITY(%s, %s)',
            $this->firstString->dispatch($sqlWalker),
            $this->secondString->dispatch($sqlWalker)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->firstString = $parser->StringPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->secondString = $parser->StringPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
