<?php

namespace Paste;

class Paste {

	// --------------------------------
	//  Config section
	// --------------------------------

	public static $config = array(

		// paste format version
		"version" => 1,

		// paste uid length
		"uid_length" => 7,

		// directory, where pastes are stored
		"paste_dir" => "files",

		// syntax options
		"syntax_default" => "plain",
		"syntax_list" => array(
			"plain"        => array( "name" => "plaintext" ),
			"actionscript" => array( "name" => "actionscript" ),
			"apache"       => array( "name" => "apache" ),
			"applescript"  => array( "name" => "applescript" ),
			"asciidoc"     => array( "name" => "asciidoc" ),
			"avrasm"       => array( "name" => "avr-asm" ),
			"bash"         => array( "name" => "bash" ),
			"bat"          => array( "name" => "bat" ),
			"c"            => array( "name" => "c" ),
			"cpp"          => array( "name" => "c++" ),
			"capnproto"    => array( "name" => "capnproto" ),
			"clojure"      => array( "name" => "clojure" ),
			"cmake"        => array( "name" => "cmake" ),
			"coffescript"  => array( "name" => "coffescript" ),
			"csharp"       => array( "name" => "c#" ),
			"css"          => array( "name" => "css" ),
			"d"            => array( "name" => "d" ),
			"dart"         => array( "name" => "dart" ),
			"delphi"       => array( "name" => "delphi" ),
			"diff"         => array( "name" => "diff" ),
			"django"       => array( "name" => "django" ),
			"dust"         => array( "name" => "dust" ),
			"elixir"       => array( "name" => "elixir" ),
			"erlang"       => array( "name" => "erlang" ),
			"fsharp"       => array( "name" => "f#" ),
			"glsl"         => array( "name" => "glsl" ),
			"go"           => array( "name" => "go" ),
			"gradle"       => array( "name" => "gradle" ),
			"groovy"       => array( "name" => "groovy" ),
			"haml"         => array( "name" => "haml" ),
			"handlebars"   => array( "name" => "handlebars" ),
			"haskell"      => array( "name" => "haskell" ),
			"haxe"         => array( "name" => "haxe" ),
			"html"         => array( "name" => "html" ),
			"http"         => array( "name" => "http" ),
			"ini"          => array( "name" => "ini" ),
			"java"         => array( "name" => "java" ),
			"javascript"   => array( "name" => "javascript" ),
			"json"         => array( "name" => "json" ),
			"lasso"        => array( "name" => "lasso" ),
			"less"         => array( "name" => "less" ),
			"lisp"         => array( "name" => "lisp" ),
			"livescript"   => array( "name" => "livescript" ),
			"lua"          => array( "name" => "lua" ),
			"makefile"     => array( "name" => "makefile" ),
			"markdown"     => array( "name" => "markdown" ),
			"mathematica"  => array( "name" => "mathematica" ),
			"matlab"       => array( "name" => "matlab" ),
			"objectivec"   => array( "name" => "objective-c" ),
			"ocaml"        => array( "name" => "ocaml" ),
			"oxygene"      => array( "name" => "oxygene" ),
			"delphi"       => array( "name" => "pascal" ),
			"perl"         => array( "name" => "perl" ),
			"php"          => array( "name" => "php" ),
			"powershell"   => array( "name" => "powershell" ),
			"processing"   => array( "name" => "processing" ),
			"protobuf"     => array( "name" => "protobuf" ),
			"python"       => array( "name" => "python" ),
			"ruby"         => array( "name" => "ruby" ),
			"rust"         => array( "name" => "rust" ),
			"scala"        => array( "name" => "scala" ),
			"scheme"       => array( "name" => "scheme" ),
			"scilab"       => array( "name" => "scilab" ),
			"scss"         => array( "name" => "scss" ),
			"sh"           => array( "name" => "sh" ),
			"smalltalk"    => array( "name" => "smalltalk" ),
			"sql"          => array( "name" => "sql" ),
			"styl"         => array( "name" => "styl" ),
			"swift"        => array( "name" => "swift" ),
			"tcl"          => array( "name" => "tcl" ),
			"tex"          => array( "name" => "tex" ),
			"thrift"       => array( "name" => "thrift" ),
			"twig"         => array( "name" => "twig" ),
			"typescript"   => array( "name" => "typescript" ),
			"vala"         => array( "name" => "vala" ),
			"vbnet"        => array( "name" => "vbnet" ),
			"vbscript"     => array( "name" => "vbscript" ),
			"vim"          => array( "name" => "vim" ),
			"x86asm"       => array( "name" => "x86-asm" ),
			"xml"          => array( "name" => "xml" ),
		),

	);


	// --------------------------------
	//  Public properties
	// --------------------------------

	public $text;
	public $syntax;
	public $uid;


	// --------------------------------
	//  Contructor
	// --------------------------------

	public function __construct( $uid = null ) {
		if ( $uid !== null ) {
			$this->uid = $uid;
		}
	}


	// --------------------------------
	//  Static methods
	// --------------------------------

	// create paste
	public static function create( $text, $syntax ) {
		$paste = new self();
		$paste->syntax = $syntax;
		$paste->text = $text;
		$paste->uid = Helper::getRandString( self::$config["uid_length"] );
		return $paste;
	}


	// --------------------------------
	//  Object methods
	// --------------------------------

	// check syntax availability
	public function isSyntaxAvailable() {
		return array_key_exists( $this->syntax, self::$config[ "syntax_list" ] );
	}

	public function setDefaultSyntax() {
		$this->syntax = self::$config[ "syntax_default" ];
		return $this;
	}

	public function getFileName() {
		return self::$config["paste_dir"] . "/" . $this->uid . ".txt";
	}

	// save paste
	public function save() {
		if ( ! $this->isSyntaxAvailable() ) {
			$this->setDefaultSyntax();
		}
		$content  = "PASTE/" . self::$config[ "version" ] . "\n";
		$content .= $this->syntax . "\n";
		$content .= base64_encode( $this->text ) . "\n";
		try {
			$status = file_put_contents( $this->getFileName(), $content, LOCK_EX );
		} catch ( \Exception $e ) {
			throw new PasteException( "file_write_error" );
		}
		if ( ! $status ) {
			throw new PasteException( "file_write_error" );
		}
		return $this;
	}

	// load paste
	public function load() {
		try {
			$content = file_get_contents( $this->getFileName() );
		} catch ( \Exception $e ) {
			if ( $e->getCode() == 2 ) {
				throw new PasteException( "file_not_found" );
			}
			throw new PasteException( "file_read_error" );
		}
		if ( ! $content ) {
			throw new PasteException( "file_read_error" );
		}
		$content_a = explode( "\n", $content );
		if ( $content_a[ 0 ] != "PASTE/" . self::$config[ "version" ] ) {
			throw new PasteException( "paste_version_mismatch" );
		}
		$this->syntax = $content_a[ 1 ];
		$this->text = base64_decode( $content_a[ 2 ] );
		return $this;
	}

}
