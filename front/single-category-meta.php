<?php


if (!class_exists('wsppcp_product_categories_hook_content')) {



    class wsppcp_product_categories_hook_content
    {


        /** Product Category Meta Print Start */
        public  $all_categories_hook ="";
        public function wsppcp_construct_function(){
            
            add_action('wp', array($this, 'wsppcp_product_categories_print_content_class'));
            add_action( 'wp', array($this,'wsppcp_single_product_print_content'));
        }
        
        function wsppcp_product_categories_print_content_class(){

            $pos1 = $pos2  = $pos3 = $pos4 = $pos5 = $pos6 = $pos7 = $pos8 = $pos9 = $pos10 = $pos11 = $pos12 = $pos13 = $pos14 = $pos15 = $pos16 = $pos17 = $pos18 = $pos19 = $pos20 = array();                
            if (!is_admin()) {
                $product_id =  get_the_ID();
                $wsppcp_product_cat = get_the_terms($product_id, 'product_cat');
                $wsppcp_all_product_cat = array();

                if (isset($wsppcp_product_cat) && !empty($wsppcp_product_cat)) {
                    foreach ($wsppcp_product_cat as $productInfo) {
                        $term_id = $productInfo->term_id;
                        $wsppcp_all_product_cat[] = $term_id;
                        if (isset($productInfo->parent) && $productInfo->parent != 0) {
                            $wsppcp_all_product_cat[] = $productInfo->parent;
                        }
                    }
                }

                if (!empty($wsppcp_all_product_cat) && isset($wsppcp_all_product_cat)) {

                    $wsppcp_all_product_cat = array_unique($wsppcp_all_product_cat);
                    foreach ($wsppcp_all_product_cat as $term_id) { 

                        $all_categories_hook = get_term_meta($term_id, 'wsppcp_product_categories_position', true);

                        if (!empty($all_categories_hook) && count($all_categories_hook) != 0) {                    
                            foreach($all_categories_hook as $key => $wsppcp_hook){
                                
                                if($key == 'woocommerce_before_single_product'){
                                    $pos1[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos1'),10);
                                                                        
                                }elseif($key == 'woocommerce_before_single_product_summary'){

                                    $pos2[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);                                  
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos2'),10);

                                }elseif($key == 'woocommerce_single_product_summary'){
                                    
                                    $pos3[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',4);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos3'),4);

                                }elseif($key == 'woocommerce_after_product_title'){
                
                                    $pos4[] = $wsppcp_hook;
                                    remove_action( 'woocommerce_single_product_summary','woocommerce_after_product_title',5);
                                    add_action( 'woocommerce_single_product_summary', array( $this, 'wsppcp_product_category_page_content_pos4'),5);
                    
                                }elseif($key == 'woocommerce_after_product_price'){
                    
                                    $pos5[] = $wsppcp_hook;
                                    remove_action( 'woocommerce_single_product_summary' , 'woocommerce_after_product_price' ,10);
                                    add_action( 'woocommerce_single_product_summary', array( $this, 'wsppcp_product_category_page_content_pos5'),10);
                    
                                }elseif($key == 'woocommerce_before_add_to_cart_form'){
                    
                                    $pos6[] = $wsppcp_hook;
                                    remove_action( 'woocommerce_before_add_to_cart_form' , 'wsppcp_single_product_page_hook' ,10);
                                    add_action( 'woocommerce_before_add_to_cart_form' , array( $this, 'wsppcp_product_category_page_content_pos6') ,10);
                    
                                }elseif($key == 'woocommerce_before_variations_form'){
                    
                                    $pos7[] = $wsppcp_hook;
                                    remove_action( $key , 'wsppcp_single_product_page_hook' ,10);
                                    add_action( $key , array( $this, 'wsppcp_product_category_page_content_pos7') ,10);
                    
                                }elseif($key == 'woocommerce_before_add_to_cart_button'){	
                    
                                    $pos8[] = $wsppcp_hook;
                                    remove_action( $key,'wsppcp_single_product_page_hook',10);
                                    add_action( $key,array( $this, 'wsppcp_product_category_page_content_pos8'),10);
                    
                                }elseif($key == 'woocommerce_before_single_variation'){
                    
                                    $pos9[] = $wsppcp_hook;
                                    remove_action( $key,'wsppcp_single_product_page_hook',10);
                                    add_action( $key,array( $this, 'wsppcp_product_category_page_content_pos9'),10);
                    
                                }elseif($key == 'woocommerce_single_variation'){
                    
                                    $pos10[] = $wsppcp_hook;
                                    remove_action( $key,'wsppcp_single_product_page_hook',10);				
                                    add_action( $key,array( $this, 'wsppcp_product_category_page_content_pos10'),10);				
                                    
                                }elseif($key == 'woocommerce_after_single_variation'){
                    
                                    $pos11[] = $wsppcp_hook;
                                    remove_action( $key,'wsppcp_single_product_page_hook',10);				
                                    add_action( $key,array( $this,'wsppcp_product_category_page_content_pos11'),10);				
                                    
                                }elseif($key == 'woocommerce_after_add_to_cart_button'){

                                    $pos12[] = $wsppcp_hook;
                                    remove_action( $key,'wsppcp_single_product_page_hook',10);
                                    add_action( $key,array( $this,'wsppcp_product_category_page_content_pos12'),10);
                                    
                                }elseif($key == 'woocommerce_after_variations_form'){

                                    $pos13[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos13'),10);

                                }elseif($key == 'woocommerce_after_add_to_cart_form'){
                                    
                                    $pos14[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos14'),10);

                                }elseif($key == 'woocommerce_product_meta_start'){
                                    
                                    $pos15[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos15'),10);

                                }elseif($key == 'woocommerce_product_meta_end'){
                                    
                                    $pos16[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos16'),10);

                                }elseif($key == 'woocommerce_share'){
                                    
                                    $pos17[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos17'),10);

                                }elseif($key == 'woocommerce_product_thumbnails'){
                
                                    $pos18[] = $wsppcp_hook;
                                    remove_action( 'woocommerce_after_single_product_summary','woocommerce_product_thumbnails',5);
                                    add_action( 'woocommerce_after_single_product_summary',array( $this,'wsppcp_product_category_page_content_pos18'),5);
                                    
                                }elseif($key == 'woocommerce_after_single_product_summary'){

                                    $pos19[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',8);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos19'),8);

                                }elseif($key == 'woocommerce_after_single_product'){
                                    
                                    $pos20[] = $wsppcp_hook;
                                    remove_action( $key, 'wsppcp_single_product_page_hook',10);
                                    add_action( $key, array( $this, 'wsppcp_product_category_page_content_pos20'),10);   
                                }
                          
                            }
                            $this->pos1 = $pos1;
                            $this->pos2 = $pos2;
                            $this->pos3 = $pos3;
                            $this->pos4 = $pos4;
                            $this->pos5 = $pos5;
                            $this->pos6 = $pos6;
                            $this->pos7 = $pos7;
                            $this->pos8 = $pos8;
                            $this->pos9 = $pos9;
                            $this->pos10 = $pos10;
                            $this->pos11 = $pos11;
                            $this->pos12 = $pos12;
                            $this->pos13 = $pos13;
                            $this->pos14 = $pos14;
                            $this->pos15 = $pos15;
                            $this->pos16 = $pos16;
                            $this->pos17 = $pos17;
                            $this->pos18 = $pos18;
                            $this->pos19 = $pos19;
                            $this->pos20 = $pos20;
                        }
                    }
                }
            }
        }
        
        public function wsppcp_product_category_page_content_pos1(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos1 '>";                
                foreach ($this->pos1 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            function wsppcp_product_category_page_content_pos2(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos2 '>";
                foreach ($this->pos2 as $key => $value) {
                    echo wsppcp_output($value);              
                }      
                echo "</div>";  
        
            }
            public function wsppcp_product_category_page_content_pos3(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos3 '>";                
                foreach ($this->pos3 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            public function wsppcp_product_category_page_content_pos4(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos4 '>";                
                foreach ($this->pos4 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            public function wsppcp_product_category_page_content_pos5(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos5 '>";                
                foreach ($this->pos5 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            public function wsppcp_product_category_page_content_pos6(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos6 '>";                
                foreach ($this->pos6 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            public function wsppcp_product_category_page_content_pos7(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos7 '>";                
                foreach ($this->pos7 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            public function wsppcp_product_category_page_content_pos8(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos8 '>";                
                foreach ($this->pos8 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            public function wsppcp_product_category_page_content_pos9(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos9 '>";                
                foreach ($this->pos9 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";   
        
            }
            public function wsppcp_product_category_page_content_pos10(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos10 '>";                
                foreach ($this->pos10 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos11(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos11 '>";                
                foreach ($this->pos11 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos12(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos12 '>";                
                foreach ($this->pos12 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos13(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos13 '>";                
                foreach ($this->pos13 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos14(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos14 '>";                
                foreach ($this->pos14 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos15(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos15 '>";                
                foreach ($this->pos15 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos16(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos16 '>";                
                foreach ($this->pos16 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos17(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos17 '>";                
                foreach ($this->pos17 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos18(){

                echo "<div class='wsppcp_category_pos18 woocommerce_product_thumbnails'>";                
                foreach ($this->pos18 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos19(){

                echo "<div class='wsppcp_div_block wsppcp_product_summary_text'>";                
                foreach ($this->pos19 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
        
            }
            public function wsppcp_product_category_page_content_pos20(){

                echo "<div class='wsppcp_div_block wsppcp_category_pos20 '>";                
                foreach ($this->pos20 as $key => $value) {
                    echo wsppcp_output($value);  
                }
                echo "</div>";    
       
        }
        /** Product Category Meta Print End */

        /** Single Product Meta Print Start  */

        function wsppcp_single_product_print_content() {
	
            if ( !is_admin() ) { 
                $product_id=  get_the_ID();
                $single_page_hook_list = get_post_meta($product_id, 'wsppcp_single_product_position');
        
                if(!empty($single_page_hook_list) && isset($single_page_hook_list)){
                    $single_page_hook_list = $single_page_hook_list[0];
                    foreach($single_page_hook_list as $key => $wsppcp_hook){
                        
                        if($key == 'woocommerce_before_single_product'){
                            $this->single_pos1 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos1'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos1'),10);
                            
                            
                        }elseif($key == 'woocommerce_before_single_product_summary'){

                            $this->single_pos2 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos2'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos2'),10);

                        }elseif($key == 'woocommerce_single_product_summary'){

                            $this->single_pos3 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',4);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos3'),4);
                            add_action( $key, array($this,'wsppcp_product_single_page_content_pos3'),4);

                        }elseif($key == 'woocommerce_after_product_title'){

                            $this->single_pos4 = $wsppcp_hook;
                            remove_action( 'woocommerce_single_product_summary','woocommerce_after_product_title',5);
                            remove_action( 'woocommerce_single_product_summary', array($this,'wsppcp_product_category_page_content_pos4'),5);
                            add_action( 'woocommerce_single_product_summary',array($this,'wsppcp_product_single_page_content_pos4'),5);

                        }elseif($key == 'woocommerce_after_product_price'){

                            $this->single_pos5 = $wsppcp_hook;

                            remove_action( 'woocommerce_single_product_summary' , 'woocommerce_after_product_price' ,10);
                            remove_action( 'woocommerce_single_product_summary', array($this,'wsppcp_product_category_page_content_pos5'),10);
                            add_action( 'woocommerce_single_product_summary' , array($this,'wsppcp_product_single_page_content_pos5') ,10);

                        }elseif($key == 'woocommerce_before_add_to_cart_form'){
                                    
                            $this->single_pos6 = $wsppcp_hook;
                            remove_action( $key , 'wsppcp_single_product_page_hook' ,10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos6'),10);
                            add_action( $key , array( $this, 'wsppcp_product_single_page_content_pos6') ,10);

                        }elseif($key == 'woocommerce_before_variations_form'){
                                    
                            $this->single_pos7 = $wsppcp_hook;
                            remove_action( $key , 'wsppcp_single_product_page_hook' ,10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos7'),10);
                            add_action( $key , array( $this, 'wsppcp_product_single_page_content_pos7') ,10);

                        }elseif($key == 'woocommerce_before_add_to_cart_button'){	

                            $this->single_pos8 = $wsppcp_hook;
                            remove_action( $key,'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos8'),10);
                            add_action( $key,array($this,'wsppcp_product_single_page_content_pos8'),10);

                        }elseif($key == 'woocommerce_before_single_variation'){

                            $this->single_pos9 = $wsppcp_hook;
                            remove_action( $key ,'wsppcp_single_product_page_hook',10);
                            remove_action( $key , array($this,'wsppcp_product_category_page_content_pos9'),10);
                            add_action( $key ,array($this,'wsppcp_product_single_page_content_pos9'),10);

                        }elseif($key == 'woocommerce_single_variation'){

                            $this->single_pos10 = $wsppcp_hook;
                            remove_action( $key,'wsppcp_single_product_page_hook',10);				
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos10'),10);
                            add_action( $key,array($this,'wsppcp_product_single_page_content_pos10'),10);				
                            
                        }elseif($key == 'woocommerce_after_single_variation'){

                            $this->single_pos11 = $wsppcp_hook;
                            remove_action( $key,'wsppcp_single_product_page_hook',10);	
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos11'),10);			
                            add_action( $key,array($this,'wsppcp_product_single_page_content_pos11'),10);				
                            
                        }elseif($key == 'woocommerce_after_add_to_cart_button'){

                            $this->single_pos12 = $wsppcp_hook;
                            remove_action( $key,'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos12'),10);	
                            add_action( $key,array($this,'wsppcp_product_single_page_content_pos12'),10);
                            
                        }elseif($key == 'woocommerce_after_variations_form'){

                            $this->single_pos13 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos13'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos13'),10);

                        }elseif($key == 'woocommerce_after_add_to_cart_form'){
                                                    
                            $this->single_pos14 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos14'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos14'),10);

                        }elseif($key == 'woocommerce_product_meta_start'){
                                                    
                            $this->single_pos15 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos15'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos15'),10);

                        }elseif($key == 'woocommerce_product_meta_end'){
                                                    
                            $this->single_pos16 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos16'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos16'),10);

                        }elseif($key == 'woocommerce_share'){
                                                    
                            $this->single_pos17 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos17'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos17'),10);

                        }elseif($key == 'woocommerce_product_thumbnails'){

                            $this->single_pos18 = $wsppcp_hook;
                            remove_action( 'woocommerce_after_single_product_summary','woocommerce_product_thumbnails',5);
                            remove_action( 'woocommerce_after_single_product_summary', array($this,'wsppcp_product_category_page_content_pos18'),5);	
                            add_action( 'woocommerce_after_single_product_summary',array($this,'wsppcp_product_single_page_content_pos18'),5);
                            
                        }elseif($key == 'woocommerce_after_single_product_summary'){
                                
                            $this->single_pos19 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_product_summary_hook',8);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos19'),8);
                            add_action( $key, array($this,'wsppcp_product_single_page_content_pos19'),8);

                        }elseif($key == 'woocommerce_after_single_product'){
                                                    
                            $this->single_pos20 = $wsppcp_hook;
                            remove_action( $key, 'wsppcp_single_product_page_hook',10);
                            remove_action( $key, array($this,'wsppcp_product_category_page_content_pos20'),10);
                            add_action( $key, array( $this, 'wsppcp_product_single_page_content_pos20'),10);
                        
                            
                        }  
                    }
                }        
            }
        }

        public function wsppcp_product_single_page_content_pos1(){

            echo "<div class='wsppcp_div_block wsppcp_category_pos1 '>";
            echo wsppcp_output( $this->single_pos1 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos2(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos2 '>";
            echo wsppcp_output( $this->single_pos2 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos3(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos3 '>";
            echo wsppcp_output( $this->single_pos3 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos4(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos4 '>";
            echo wsppcp_output( $this->single_pos4 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos5(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos5 '>";
            echo wsppcp_output( $this->single_pos5 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos6(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos6 '>";
            echo wsppcp_output( $this->single_pos6 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos7(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos7 '>";
            echo wsppcp_output( $this->single_pos7 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos8(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos8 '>";
            echo wsppcp_output( $this->single_pos8 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos9(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos9 '>";
            echo wsppcp_output( $this->single_pos9 );
            echo "</div>";   
            
            }
            public function wsppcp_product_single_page_content_pos10(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos10 '>";
            echo wsppcp_output( $this->single_pos10 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos11(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos11 '>";
            echo wsppcp_output( $this->single_pos11 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos12(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos12 '>";
            echo wsppcp_output( $this->single_pos12 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos13(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos13 '>";
            echo wsppcp_output( $this->single_pos13 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos14(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos14 '>";
            echo wsppcp_output( $this->single_pos14 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos15(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos15 '>";
            echo wsppcp_output( $this->single_pos15 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos16(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos16 '>";
            echo wsppcp_output( $this->single_pos16 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos17(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos17 '>";
            echo wsppcp_output( $this->single_pos17 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos18(){
            
            echo "<div class='wsppcp_category_pos18 woocommerce_product_thumbnails'>";
            echo wsppcp_output( $this->single_pos18 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos19(){
            
            echo "<div class='wsppcp_div_block wsppcp_product_summary_text'>";
            echo wsppcp_output( $this->single_pos19 );        
            echo "</div>";    
            
            }
            public function wsppcp_product_single_page_content_pos20(){
            
            echo "<div class='wsppcp_div_block wsppcp_category_pos20 '>";
            echo wsppcp_output( $this->single_pos20 );        
            echo "</div>";                
        }

        /** Single Product Meta Print End  */

    }
}

$categories_hook  = new wsppcp_product_categories_hook_content();

$categories_hook->wsppcp_construct_function();