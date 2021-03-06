<?php

namespace Eyca;

function get_options()
{
  $data = query('
    {
      categories { id name }
      tags
      countries(members: true) { id name regions }
    }
  ');
  if ($restrict = config()['search']['restrict']) {
    if ($restrict['member']) {
      $data = array_replace($data, query('
        query ($member: ID) {
          discounts(member: $member) {
            countries { id name regions }
          }
        }
      ', $restrict)['discounts']);
    }
    if ($restrict['country'] and !$restrict['region']) {
      foreach ($data['countries'] as $item) {
        if ($item['id'] === $restrict['country']) {
          if ($item['regions']) {
            $data['regions'] = $item['regions'];
          }
          break;
        }
      }
    }
  }
  return $data;
}

function get_options_cached($ttl = CACHE_TTL)
{
  return cache('options', config()['search']['restrict'], function () {
    return get_options();
  }, CACHE_TTL);
}

function get_discounts($variables)
{
  return query('
    query ($member: ID, $country: String, $region: String, $category: String, $tag: String, $keyword: String, $type: DiscountType, $skip: Int, $limit: Int) {
      discounts(member: $member, country: $country, region: $region, category: $category, tag: $tag, query: $keyword, type: $type) {
        count
        data(skip: $skip, limit: $limit) {
          id
          name nameLocal vendor
          image
          locations(country: $country, region: $region) { count }
          categories { id name }
          tags
        }
      }
    }
  ', $variables)['discounts'];
}

function get_discounts_cached($variables, $ttl = CACHE_TTL)
{
  return cache('discounts', $variables, function () use ($variables) {
    return get_discounts($variables);
  }, CACHE_TTL);
}

function get_discount($id)
{
  return query('
    query ($id: ID!) {
      discount(id: $id) {
        id
        name nameLocal vendor
        text textLocal
        email phone web
        image
        created
        locations {
          count
          data {
            street city zip country { id name region } geo { lat lng }
          }
        }
        categories { id name }
        tags
      }
    }
  ', [ 'id' => $id ])['discount'];
}

function get_discount_cached($id, $ttl = CACHE_TTL)
{
  return cache('discount', $id, function () use ($id) {
    return get_discount($id);
  }, CACHE_TTL);
}
