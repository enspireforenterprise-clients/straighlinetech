<?php

SC_Modules::register_module_type( 'Cards', [

	'fluid'    => false,
  'size'     => 12,
  'sizes'    => [12],
  'nestable' => false

]);

if( ! class_exists( 'SC_Cards_Module' ) ) {

  class SC_Cards_Module {

    private static $_data;

    public static function get_cards_markup() {

      $cards = array();

      $counter = 1;
      $id      = self::$_data['module_id'];

      foreach( self::$_data['cards'] as $card ) {
        
        $description       = isset( $card['meta']['description'] ) ? $card['meta']['description'] : false;
        $background_color       = isset( $card['meta']['select_card_background_color'] ) ? $card['meta']['select_card_background_color'] : false;

        $id_name = $id . '_' . $counter;

        $cards[] = sprintf('
          <div class="col">
            <div class="scm-card %s">

              <span class="scm-card__text" data-mh="card__text__location" aria-hidden="true">
                %s
              </span>
              
            </div>
          </div>', 
         
            $background_color,
            $description,
          
          );

        $counter++;

      } 

      return implode( '', $cards );

    }

    public static function set_data( $data ) {

      self::$_data = $data;

    }

  } 

}
