<?php
namespace View\Helper;

use OwEventos\View\Helper\OwEventosAppHelper;
class EventoHelper extends OwEventosAppHelper{
    
    
    /**
     * 
     * @param type $evento
     * @param type $options Tipo Disponíveis: 0, 1, 2, 3, default, hqdefault, mqdefault, maxresdefault
     * @return string
     */
    public function getURLThumbnailYouTube($evento, $options = array()){
        $defaultOptions = array(
            'type' => 'default',
            'https' => false
        );
        
        $options = array_merge($defaultOptions, $options);
        
        $video = is_array($evento) ? $evento['Evento']['video'] : $evento;
        
        $str = $options['https'] ? 'https://img.youtube.com/vi/' : 'http://img.youtube.com/vi/';
        $str .= $this->getIDVideo($video) . '/';
        $str .= $options['type'] . '.jpg';
        
        return $str;
    }
     public function getURLThumbnailUol( $codigo,$options = array()){
        $defaultOptions = array(
            'type' => 'default',
            'https' => false
        );
        
        $options = array_merge($defaultOptions, $options);
        
     
        
        $str = $options['https'] ? 'https://thumb.mais.uol.com.br/'.$codigo.'-small.jpg?ver=0' : 'http://thumb.mais.uol.com.br/'.$codigo.'-small.jpg?ver=0';
     
        
        return $str;
    }
    
    public function getIDVideo($str){
        $url = $str;
        if($this->isIframe($str)){
            $matches = array();
            $url = preg_match('/src="([^"]+)"/', $str, $matches);        
            $url = $matches[1];
        }
        return $this->linkifyYouTubeURLs($url);
    }
    
    public function isIframe($str){
        return preg_match('/\<iframe/', $str);
    }
    
    private function linkifyYouTubeURLs($text) {
        $text = preg_replace('~
            # Match non-linked youtube URL in the wild. (Rev:20111012)
            https?://         # Required scheme. Either http or https.
            (?:[0-9A-Z-]+\.)? # Optional subdomain.
            (?:               # Group host alternatives.
              youtu\.be/      # Either youtu.be,
            | youtube\.com    # or youtube.com followed by
              \S*             # Allow anything up to VIDEO_ID,
              [^\w\-\s]       # but char before ID is non-ID char.
            )                 # End host alternatives.
            ([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
            (?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
            (?!               # Assert URL is not pre-linked.
              [?=&+%\w]*      # Allow URL (query) remainder.
              (?:             # Group pre-linked alternatives.
                [\'"][^<>]*>  # Either inside a start tag,
              | </a>          # or inside <a> element text contents.
              )               # End recognized pre-linked alts.
            )                 # End negative lookahead assertion.
            [?=&+%\w-]*        # Consume any URL (query) remainder.
            ~ix', 
            '$1',
            $text);
        return $text;
    }
    
    public function trocarValorWidth($str, $novoValor){
        return preg_replace('/width="([0-9]+)"/', 'width="'. $novoValor .'"', $str);
    }
    
    public function trocarValorHeight($str, $novoValor){
        return preg_replace('/height="([0-9]+)"/', 'height="'. $novoValor .'"', $str);
    }
    
    public function trocarWidthHeight($str, $newWidth, $newHeight){
        $str = $this->trocarValorWidth($str, $newWidth);
        return $this->trocarValorHeight($str, $newHeight);
    }
}
?>
