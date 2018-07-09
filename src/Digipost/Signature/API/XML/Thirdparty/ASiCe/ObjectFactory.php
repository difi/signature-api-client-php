<?php
namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

class ObjectFactory {

  public function createASiCManifest ()
	{
		return new ASiCManifest;
	}
	public function createSigReference () 
	{
		return new SigReference;
	}
	public function createDataObjectReference () 
	{
		return new DataObjectReference;
	}
	public function createExtensionsListType () 
	{
		return new ExtensionsListType;
	}
	public function createExtension () 
	{
		return new Extension;
	}
	public function createAnyType () 
	{
		return new AnyType;
	}
	public function createXAdESSignatures () 
	{
		return new XAdESSignatures;
	}
}

