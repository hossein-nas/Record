<?php
namespace App\Traits;

use App\Card;
class CardCreatorTrait{
    protected $uid = null;
    public function __construct($_uid=null){
        if ( $_uid != null ){
            $r = Card::where('uid', $_uid)->get();
            if( $r->count() )
                return $this->uid = $r->first();
        }
    }
    public function getUID(){
        return $this->uid;
    }

    static public function createCard($card){
        $_c = new CardCreatorTrait($card['uid']);
        if( $_c->getUID() == null ){
            $r = Card::create($card);
            return $r;
        }
        return null;
    }

    static public function getCard($uid){
        $_c = new CardCreatorTrait($uid);
        if( $_c->getUID() != null ){
            return $_c->getUID();
        }
        return null;
    }
}