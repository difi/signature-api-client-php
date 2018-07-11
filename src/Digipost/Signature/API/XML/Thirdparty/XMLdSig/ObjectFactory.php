<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Digipost\Signature\JAXB\JAXBElement;

class ObjectFactory {

  protected static $_DigestValue_QNAME;

  protected static $_KeyName_QNAME;

  protected static $_MgmtData_QNAME;

  protected static $_SignatureMethodHMACOutputLength_QNAME;

  protected static $_TransformXPath_QNAME;

  protected static $_X509DataX509IssuerSerial_QNAME;

  protected static $_X509DataX509SKI_QNAME;

  protected static $_X509DataX509SubjectName_QNAME;

  protected static $_X509DataX509Certificate_QNAME;

  protected static $_X509DataX509CRL_QNAME;

  protected static $_SPKIDataSPKISexp_QNAME;

  public static function __staticinit() {
    self::$_DigestValue_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                          "DigestValue");
    self::$_KeyName_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                      "KeyName");
    self::$_MgmtData_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                       "MgmtData");
    self::$_SignatureMethodHMACOutputLength_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                                              "HMACOutputLength");
    self::$_TransformXPath_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                             "XPath");
    self::$_X509DataX509IssuerSerial_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                                       "X509IssuerSerial");
    self::$_X509DataX509SKI_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                              "X509SKI");
    self::$_X509DataX509SubjectName_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                                      "X509SubjectName");
    self::$_X509DataX509Certificate_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                                      "X509Certificate");
    self::$_X509DataX509CRL_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                              "X509CRL");
    self::$_SPKIDataSPKISexp_QNAME = new QName("http://www.w3.org/2000/09/xmldsig#",
                                               "SPKISexp");
  }

  public function createDigestMethod() {
    return new DigestMethod();
  }

  public function createSignature() {
    return new Signature();
  }

  public function createSignedInfo() {
    return new SignedInfo();
  }

  public function createCanonicalizationMethod() {
    return new CanonicalizationMethod();
  }

  public function createSignatureMethod() {
    return new SignatureMethod();
  }

  public function createReference() {
    return new Reference();
  }

  public function createTransforms() {
    return new Transforms();
  }

  public function createTransform() {
    return new Transform();
  }

  public function createSignatureValue() {
    return new SignatureValue();
  }

  public function createKeyInfo() {
    return new KeyInfo();
  }

  public function createKeyValue() {
    return new KeyValue();
  }

  public function createDSAKeyValue() {
    return new DSAKeyValue();
  }

  public function createRSAKeyValue() {
    return new RSAKeyValue();
  }

  public function createRetrievalMethod() {
    return new RetrievalMethod();
  }

  public function createX509Data() {
    return new X509Data();
  }

  public function createX509IssuerSerialType() {
    return new X509IssuerSerialType();
  }

  public function createPGPData() {
    return new PGPData();
  }

  public function createSPKIData() {
    return new SPKIData();
  }

  public function createObject() {
    return new ObjectType();
  }

  public function createManifest() {
    return new Manifest();
  }

  public function createSignatureProperties() {
    return new SignatureProperties();
  }

  public function createSignatureProperty() {
    return new SignatureProperty();
  }

  public function createDigestValue($value) {
    return new JAXBElement(self::$_DigestValue_QNAME, $value);
  }

  public function createKeyName($value) {
    return new JAXBElement(self::$_KeyName_QNAME, $value);
  }

  public function createMgmtData($value) {
    return new JAXBElement(self::$_MgmtData_QNAME, $value);
  }

  public function createSignatureMethodHMACOutputLength($value) {
    return new JAXBElement(self::$_SignatureMethodHMACOutputLength_QNAME,
                           $value);
  }

  public function createTransformXPath($value) {
    return new JAXBElement(self::$_TransformXPath_QNAME, $value);
  }

  public function createX509DataX509IssuerSerial($value) {
    return new JAXBElement(self::$_X509DataX509IssuerSerial_QNAME, $value);
  }

  public function createX509DataX509SKI($value) {
    return new JAXBElement(self::$_X509DataX509SKI_QNAME, $value);
  }

  public function createX509DataX509SubjectName($value) {
    return new JAXBElement(self::$_X509DataX509SubjectName_QNAME, $value);
  }

  public function createX509DataX509Certificate($value) {
    return new JAXBElement(self::$_X509DataX509Certificate_QNAME, $value);
  }

  public function createX509DataX509CRL($value) {
    return new JAXBElement(self::$_X509DataX509CRL_QNAME, $value);
  }

  public function createSPKIDataSPKISexp($value) {
    return new JAXBElement(self::$_SPKIDataSPKISexp_QNAME, $value);
  }
}

ObjectFactory::__staticinit();

