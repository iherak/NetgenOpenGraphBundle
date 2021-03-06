<?php

namespace Netgen\Bundle\OpenGraphBundle\MetaTag;

use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;

class Renderer
{
    /**
     * Renders provided meta tags
     *
     * @param \Netgen\Bundle\OpenGraphBundle\MetaTag\Item[]
     *
     * @return string
     */
    public function render( array $metaTags = array() )
    {
        $html = '';

        foreach ( $metaTags as $metaTag )
        {
            if ( !$metaTag instanceof Item )
            {
                throw new InvalidArgumentException( 'metaTags', 'Cannot render meta tag, not an instance of \Netgen\Bundle\OpenGraphBundle\MetaTag\Item' );
            }

            $tagName = htmlspecialchars( $metaTag->getTagName(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
            $tagValue = htmlspecialchars( $metaTag->getTagValue(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );

            if ( !empty( $tagName ) && !empty( $tagValue ) )
            {
                $html .= "<meta property=\"$tagName\" content=\"$tagValue\" />\n";
            }
        }

        return $html;
    }
}
