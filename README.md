# wp_dsearch
Return sumplify posts list

## Install
Install as standart plugin. Require WP Rest-API
1. *git clone* or download to /wp-content/plugins/
2. In WP activate plugin

## Request

**Route**
> /wp-json/dsearch/v1/posts?search=text&posts_per_page=20&exact=1&categories=33


**Params**
```
{String} search | default null
{Number} posts_per_page | default WP_param //-1 for all
{Boolean} exact | default 0 //set 1 for toggle
{Number} categories | default null
```

## Return

```
    [
        {Number} 'ID' => $post->ID,
        {String} 'post_title' => $post->post_title,
        {String} 'slug' => $post->post_name,
        {Date ISO} 'post_date' => $post->post_date,
        {Number} 'post_parent' => $post->post_parent,
        {Array<Number>} 'categories' => wp_get_post_categories($post->ID),
    ]
```

### Sample
```
    {
        "ID": 391,
        "post_title": "Бурсит",
        "slug": "bursit",
        "post_date": "2019-04-27 12:22:46",
        "post_parent": 0,
        "categories": [ 33 ]
    }
```