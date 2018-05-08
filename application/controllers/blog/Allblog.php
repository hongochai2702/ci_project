<?php
class Allblog extends MX_Controller {
	public function __Construct(){
		parent::__Construct();
		$this->load->library('pagination');
	}
	public function index() {
		$this->lang->load('blog/allblog');

		$this->load->model('blog_model');

		$this->load->model('tool/image_model');

		if ($this->input->get('filter')) {
			$filter = $this->input->get('filter');
		} else {
			$filter = '';
		}

		if ($this->input->get('sort')) {
			$sort = $this->input->get('sort');
		} else {
			$sort = 'p.sort_order';
		}

		if ($this->input->get('order')) {
			$order = $this->input->get('order');
		} else {
			$order = 'ASC';
		}

		if ($this->input->get('page')) {
			$page = $this->input->get('page');
		} else {
			$page = 1;
		}

		if ($this->input->get('limit')) {
			$limit = (int)$this->input->get('limit');
		} else {
			$limit = $this->configs->get('theme_' . $this->configs->get('config_theme') . '_blog_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/home')
		);


			$this->document->setTitle($this->lang->line('text_title'));
			$this->document->setDescription($this->lang->line('text_description'));
			$this->document->setKeywords($this->lang->line('text_keywords'));
			$data['heading_title'] = $this->lang->line('text_heading_title');

			$data['text_compare'] = sprintf($this->lang->line('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			// Set the last allblog breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => 'Show All Blogs',
				'href' => $this->url->link('blog/allblog')
			);


			$data['compare'] = $this->url->link('blog/compare');

			$url = '';

			if ($this->input->get('filter')) {
				$url .= '&filter=' . $this->input->get('filter');
			}

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			if ($this->input->get('limit')) {
				$url .= '&limit=' . $this->input->get('limit');
			}

			$data['blogs'] = array();

			$filter_data = array(
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			$blog_total = $this->blog_model->getTotalBlogs($filter_data);

			$results = $this->blog_model->getBlogs($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->image_model->resize($result['image'], $this->configs->get('theme_' . $this->configs->get('config_theme') . '_image_blog_width'), $this->configs->get('theme_' . $this->configs->get('config_theme') . '_image_blog_height'));
				} else {
					$image = $this->image_model->resize('placeholder.png', $this->configs->get('theme_' . $this->configs->get('config_theme') . '_image_blog_width'), $this->configs->get('theme_' . $this->configs->get('config_theme') . '_image_blog_height'));
				}

				



				if ($this->configs->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$data['blogs'][] = array(
					'blog_id'  => $result['blog_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->configs->get('theme_' . $this->configs->get('config_theme') . '_blog_description_length')) . '..',
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('blog/allblog', '&blog_id=' . $result['blog_id'] . $url)
				);
			}

			$data['text_refine'] = $this->lang->line('text_refine');
            $data['text_empty'] = $this->lang->line('text_empty');
            $data['text_quantity'] = $this->lang->line('text_quantity');
            $data['text_manufacturer'] = $this->lang->line('text_manufacturer');
            $data['text_model'] = $this->lang->line('text_model');
            
            $data['text_tax'] = $this->lang->line('text_tax');
            $data['text_points'] = $this->lang->line('text_points');
            $data['text_compare'] = sprintf($this->lang->line('text_compare'), (($this->session->userdata('compare')) ? count($this->session->userdata('compare')) : 0));
            $data['text_sort'] = $this->lang->line('text_sort');
            $data['text_limit'] = $this->lang->line('text_limit');

            $data['button_cart'] = $this->lang->line('button_cart');
            $data['button_wishlist'] = $this->lang->line('button_wishlist');
            $data['button_compare'] = $this->lang->line('button_compare');
            $data['button_continue'] = $this->lang->line('button_continue');
            $data['button_list'] = $this->lang->line('button_list');
            $data['button_grid'] = $this->lang->line('button_grid');

			$url = '';

			if ($this->input->get('filter')) {
				$url .= '&filter=' . $this->input->get('filter');
			}

			if ($this->input->get('limit')) {
				$url .= '&limit=' . $this->input->get('limit');
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->lang->line('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('blog/allblog',  '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->lang->line('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('blog/allblog',  '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->lang->line('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('blog/allblog',  '&sort=pd.name&order=DESC' . $url)
			);

			
			

			if ($this->configs->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->lang->line('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('blog/allblog',  '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->lang->line('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('blog/allblog',  '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->lang->line('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('blog/allblog',  '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->lang->line('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('blog/allblog',  '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if ($this->input->get('filter')) {
				$url .= '&filter=' . $this->input->get('filter');
			}

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->configs->get('theme_' . $this->configs->get('config_theme') . '_blog_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('blog/allblog',  $url . '&limit=' . $value)
				);
			}

			$url = '';

			if ($this->input->get('filter')) {
				$url .= '&filter=' . $this->input->get('filter');
			}

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			if ($this->input->get('limit')) {
				$url .= '&limit=' . $this->input->get('limit');
			}
			$this->pagination->total = $blog_total;
			$this->pagination->page = $page;
			$this->pagination->limit = $limit;
			$this->pagination->url = $this->url->link('blog/allblog',  $url . '&page={page}');

			$data['pagination'] = $this->pagination->render();

			$data['results'] = sprintf($this->lang->line('text_pagination'), ($blog_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($blog_total - $limit)) ? $blog_total : ((($page - 1) * $limit) + $limit), $blog_total, ceil($blog_total / $limit));

			if ($page == 1) {
			    $this->document->addLink($this->url->link('blog/allblog'), 'canonical');
			} else {
				$this->document->addLink($this->url->link('blog/allblog', '&page='. $page), 'canonical');
			}
			
			if ($page > 1) {
			    $this->document->addLink($this->url->link('blog/allblog', (($page - 2) ? '&page='. ($page - 1) : '')), 'prev');
			}

			if ($limit && ceil($blog_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('blog/allblog', '&page='. ($page + 1)), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->load->view('default/blog/allblog', $data);

	}
}
