<?php
/* Classes */
class Stack
{
    private $stack = array();

    public function push( $value )
    {
       $this->stack[ count( $this->stack ) ] = $value;
    }

    public function pop()
    {
        try
        {
           unset( $this->stack[ count( $this->stack ) - 1 ] );
        }
        catch (\Exception $error)
        {
            echo 'Error: ' . $error;
        }
    }

    public function size() : int
    {
        return count( $this->stack );
    }

    public function last()
    {
        try
        {
           return $this->stack[ count( $this->stack ) - 1 ];
        }
        catch (\Exception $error)
        {
            echo 'Error: ' . $error;
        }
    }
}

class Brackets
{
    private $positions;
    public $type;

    public function __construct( $type, $openPosition )
    {
        $this->type = $type;

        $this->positions =
        [
           'open' => $openPosition,
           'close' => null
        ];
    }

    public function setOpenPosition( $value )
    {
        $this->positions[ 'open' ] = $value;
    }

    public function setClosePosition( $value )
    {
        $this->positions[ 'close' ] = $value;
    }

    public function checkPositions() : bool
    {
        return $this->positions[ 'close' ] != null;
    }
}

/* function */
function check( $expression ) : string
{
     $symbols = str_split( $expression );
     $stack = new Stack();
     $brackets = Array();

     $bracketTypes =
     [
         'open' => [
             'round' => '(' ,
             'square' => '[',
             'curly' => '{'
         ],
         'close' => [
             'round' => ')',
             'square' => ']',
             'curly' =>  '}'
         ]
     ];

     foreach ( $symbols as $position => $symbol )
     {
        if( in_array( $symbol, $bracketTypes['open'] ) )
        {
            $template = new Brackets( array_keys( $bracketTypes['open'], $symbol ) , $position );
            array_push( $brackets, $template );
            $stack->push( $template );
        }

        if( in_array( $symbol, $bracketTypes['close'] ) )
        {
            if( empty( $stack->last() ) )
                return 'Не верно';

            $last = $stack->last();

            if( $last->type == array_keys( $bracketTypes['close'], $symbol ) )
            {
                $last->setClosePosition( $position );
                $stack->pop();
            }
        }
     }

     foreach( $brackets as $bracket )
         if( !$bracket->checkPositions() )
            return 'Не верно' ;

     return 'Верно';
}

/* outputs */
echo '<p>[]()</p>' . check( '[]()' ) .'<br>';
echo '<p>[(]()</p>' . check( '[(]()' ) .'<br>';
echo '<p>)[(]()</p>' . check( ')[(]()' ) . '<br>';
echo '<p>{}[]()</p>' . check( '{}[]()' ) . '<br>';
echo '<p>([(]){(})</p>' . check( '([(]){(})' ) . '<br>';
echo '<p>{([][])([][])}</p>' . check( '{([][])([][])}' ) . '<br>';
echo '<p>({)[}]</p>' . check( '({)[}]' ) . '<br>';
?>
