<?php

namespace PHPShopify;

/**
 * --------------------------------------------------------------------------
 * Collection -> Child Resources
 * --------------------------------------------------------------------------
 *
 * @property-read Product $Product
 * @property-read Metafield $Metafield
 *
 * @method Product Product(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/collection
 *
 */
class Collection extends ShopifyResource
{
    /**
     * @inheritDoc
     */
    public $readOnly = false;

    /**
     * @inheritDoc
     */
    protected $resourceKey = 'collection';

    /**
     * @inheritDoc
     */
    protected $childResource = array(
        'Product',
        'Metafield',
    );
}
