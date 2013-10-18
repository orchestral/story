guard :phpunit, :all_on_start => false, :tests_path => 'tests/', :cli => '--colors -c build/phpunit.xml' do
	# Run any test in app/tests upon save.
	watch(%r{^.+Test\.php$})

	# When a file is edited, try to run its associated test.
	watch(%r{^src/(.+)/(.+)\.php$}) { |m| "tests/#{m[2]}Test.php"}
end

guard 'shell' do
	watch(%r{^public/css/(.+\.less)}) { |m| 
		n m[0], "Changed" 
		`ant minify-css`
	}
end

guard 'shell' do
	watch(%r{^public/js/storycms\.js}) { |m|
		n m[0], "Changed"
		`ant minify-js`
	}
end

guard 'shell' do
	watch(%r{^public/js/storycms\.markdown\.js}) { |m|
		n m[0], "Changed"
		`ant minify-markdown-js`
	}
end
