<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$records = 5000;

		$title_parts = array(
			array(
				'these',
				'what?!?',
				'check out',
				'finally!',
				'wut?',
				'listen,',
				'shocking',
				'unexpected',
				'world-shaking',
				'record-shattering',
				'mind-numbing',
				'mindblowing',
				'curious',
				'fantastic',
				'extreme',
				'disturbing',
				'creepy',
				'helpful',
			),
			array(
				'shocking',
				'unexpected',
				'world-shaking',
				'record-shattering',
				'mind-numbing',
				'mindblowing',
				'curious',
				'fantastic',
				'extreme',
				'disturbing',
				'creepy',
				'helpful',
			),
			array(
				'ways of commiting suicide',
				'methods of gaslighting your partner',
				'criminals who were not caught',
				'games to play in two',
				'doctors who are killing people',
				'people who are killing people',
				'houses who are housing people',
				'dogs who are befriending people',
			),
		);

		$body_parts = array(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ut libero a nulla laoreet viverra in eleifend elit.',
			'Donec sit amet nunc ac neque iaculis congue ac vel ligula. Sed malesuada eget felis in commodo. Maecenas commodo, nunc eget sollicitudin finibus, nunc felis posuere elit, a finibus turpis elit id dui.',
			'Phasellus iaculis non ipsum a ultrices. Vestibulum eget luctus diam. Phasellus vestibulum dolor in tincidunt dictum. Nunc quis ante id erat fermentum accumsan.',
			'Fusce posuere magna eu ante sagittis varius. Vivamus at magna pretium, condimentum ante a, mattis ante. Vivamus urna neque, feugiat vel dictum vel, tempus vel nibh.',
			'Sed rutrum nibh a magna iaculis laoreet. Vivamus sollicitudin risus ac tincidunt molestie. Praesent bibendum, libero in varius hendrerit, orci erat euismod odio, at luctus dui nisl et nunc.',
			'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;',
			'Mauris in ex tellus. Quisque vitae dui ipsum. Phasellus accumsan a tortor eget semper.',
			'Donec risus quam, finibus at dolor nec, blandit efficitur purus. Suspendisse vitae dui in nulla ornare accumsan condimentum id lacus. Duis gravida odio nunc.',
			'Suspendisse laoreet augue ornare lectus venenatis convallis. Duis molestie at ante volutpat pretium. Duis dolor turpis, aliquam eu mattis ac, hendrerit vel velit.',
			'Donec sit amet turpis quis felis pharetra mattis. Fusce vitae sodales massa. Proin tempor quam mi, volutpat venenatis odio semper vitae. In hac habitasse platea dictumst.',
			'Quisque at maximus ipsum, et gravida elit. Cras finibus ligula quam, ac efficitur est hendrerit sit amet. Fusce vitae pellentesque justo.',
			'Fusce efficitur luctus lobortis. Phasellus at sem odio. Donec pretium lobortis arcu sit amet dignissim. Nam iaculis nec odio eget tempus.',
			'Etiam aliquam fermentum lobortis. Duis ut tempor sapien. In posuere sapien at arcu pharetra, ac rutrum ipsum malesuada. Maecenas placerat elit sit amet accumsan tincidunt.',
			'Sed facilisis semper sapien ac eleifend. Ut erat odio, dapibus sed euismod id, suscipit sed risus. Donec gravida justo augue. Praesent sed ligula semper ante efficitur auctor non hendrerit libero.',
			'Curabitur fringilla leo at arcu sollicitudin iaculis. Duis laoreet orci sit amet efficitur aliquam. Nunc placerat mauris a molestie accumsan.',
			'Duis porta posuere metus, sed aliquam nisl malesuada a. Quisque nec suscipit est, sed viverra tortor. Nulla laoreet massa pulvinar nibh interdum, id suscipit mauris faucibus.',
			'Nam tempor, massa id ornare scelerisque, eros libero ullamcorper turpis, non posuere urna leo scelerisque nisl. Fusce eu lorem vel nibh tincidunt imperdiet.',
			'In elit lacus, accumsan a ex at, bibendum convallis est. Nullam et elementum lorem.',
		);

		$categories = array(
			'WordPress',
			'Laravel',
			'Miscellaneous',
			'DIY',
			'WTF',
			'Tips & Tricks',
		);

		$post_types = array(
			1,
			2,
		);

		for ( $i = 0; $i < $records; $i++ ) {
			$title = '';
			foreach ( $title_parts as $words ) {
				$append = $words[ array_rand( $words ) ];

				if ( rand( 0, 3 ) % 3 === 0 ) {
					$append = strtoupper( $append );
				} elseif ( rand( 0, 2 ) % 2 === 0 ) {
					$append = ucwords( $append );
				}

				if ( stripos( $title, $append ) === false ) {
					$title .= $append . ' ';
				}
			}
			$title = ucfirst( $title ) . str_random( 6 );

			$body = '';
			foreach ( array_rand( $body_parts, 12 ) as $key ) {
				$body .= $body_parts[ $key ];
				$body .= ( rand( 0, 3 ) % 3 === 0 ) ? '<br>' : ' ';
			}

			$post_type = $post_types[ array_rand( $post_types ) ];
			$category  = get_category_id( $categories[ array_rand( $categories ) ], $post_type );

			DB::table( 'posts' )->insert( array(
				'name'      => $title,
				'slug'      => str_slug( $title ),
				'body'      => $body,
				'post_type' => $post_type,
				'category'  => $category,
			) );
		}
	}
}
