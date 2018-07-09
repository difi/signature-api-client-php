<?php
namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\JAXB\JAXBElement;

class ObjectFactory {

	protected static $_XAdESTimeStamp_QNAME;
	protected static $_SigningTime_QNAME;
	protected static $_SPURI_QNAME;
	protected static $_AllDataObjectsTimeStamp_QNAME;
	protected static $_IndividualDataObjectsTimeStamp_QNAME;
	protected static $_SignatureTimeStamp_QNAME;
	protected static $_CompleteCertificateRefs_QNAME;
	protected static $_CompleteRevocationRefs_QNAME;
	protected static $_AttributeCertificateRefs_QNAME;
	protected static $_AttributeRevocationRefs_QNAME;
	protected static $_SigAndRefsTimeStamp_QNAME;
	protected static $_RefsOnlyTimeStamp_QNAME;
	protected static $_CertificateValues_QNAME;
	protected static $_RevocationValues_QNAME;
	protected static $_AttrAuthoritiesCertValues_QNAME;
	protected static $_AttributeRevocationValues_QNAME;
	protected static $_ArchiveTimeStamp_QNAME;
	protected static $_UnsignedSignaturePropertiesCounterSignature_QNAME;

	public static function __staticinit() {
		self::$_XAdESTimeStamp_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "XAdESTimeStamp");
		self::$_SigningTime_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "SigningTime");
		self::$_SPURI_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "SPURI");
		self::$_AllDataObjectsTimeStamp_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "AllDataObjectsTimeStamp");
		self::$_IndividualDataObjectsTimeStamp_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "IndividualDataObjectsTimeStamp");
		self::$_SignatureTimeStamp_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "SignatureTimeStamp");
		self::$_CompleteCertificateRefs_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "CompleteCertificateRefs");
		self::$_CompleteRevocationRefs_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "CompleteRevocationRefs");
		self::$_AttributeCertificateRefs_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "AttributeCertificateRefs");
		self::$_AttributeRevocationRefs_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "AttributeRevocationRefs");
		self::$_SigAndRefsTimeStamp_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "SigAndRefsTimeStamp");
		self::$_RefsOnlyTimeStamp_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "RefsOnlyTimeStamp");
		self::$_CertificateValues_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "CertificateValues");
		self::$_RevocationValues_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "RevocationValues");
		self::$_AttrAuthoritiesCertValues_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "AttrAuthoritiesCertValues");
		self::$_AttributeRevocationValues_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "AttributeRevocationValues");
		self::$_ArchiveTimeStamp_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "ArchiveTimeStamp");
		self::$_UnsignedSignaturePropertiesCounterSignature_QNAME = new QName("http://uri.etsi.org/01903/v1.3.2#", "CounterSignature");
	}
	public function createAny ()
	{
		return new Any();
	}
	public function createObjectIdentifier () 
	{
		return new ObjectIdentifier();
	}
	public function createIdentifierType () 
	{
		return new IdentifierType();
	}
	public function createDocumentationReferencesType () 
	{
		return new DocumentationReferencesType();
	}
	public function createEncapsulatedPKIData () 
	{
		return new EncapsulatedPKIData();
	}
	public function createInclude () 
	{
		return new IncludeType();
	}
	public function createReferenceInfo () 
	{
		return new ReferenceInfo();
	}
	public function createXAdESTimeStampType () 
	{
		return new XAdESTimeStampType();
	}
	public function createOtherTimeStamp () 
	{
		return new OtherTimeStamp();
	}
	public function createQualifyingProperties () 
	{
		return new QualifyingProperties();
	}
	public function createSignedProperties () 
	{
		return new SignedProperties();
	}
	public function createUnsignedProperties () 
	{
		return new UnsignedProperties();
	}
	public function createSignedSignatureProperties () 
	{
		return new SignedSignatureProperties();
	}
	public function createSignedDataObjectProperties () 
	{
		return new SignedDataObjectProperties();
	}
	public function createUnsignedSignatureProperties () 
	{
		return new UnsignedSignatureProperties();
	}
	public function createUnsignedDataObjectProperties () 
	{
		return new UnsignedDataObjectProperties();
	}
	public function createSigningCertificate () 
	{
		return new SigningCertificate();
	}
	public function createSignaturePolicyIdentifier () 
	{
		return new SignaturePolicyIdentifier();
	}
	public function createSignatureProductionPlace () 
	{
		return new SignatureProductionPlace();
	}
	public function createSignerRole () 
	{
		return new SignerRole();
	}
	public function createDataObjectFormat () 
	{
		return new DataObjectFormat();
	}
	public function createCommitmentTypeIndication () 
	{
		return new CommitmentTypeIndication();
	}
	public function createCounterSignature () 
	{
		return new CounterSignature();
	}
	public function createCompleteCertificateRefsType () 
	{
		return new CompleteCertificateRefsType();
	}
	public function createCompleteRevocationRefsType () 
	{
		return new CompleteRevocationRefsType();
	}
	public function createCertificateValuesType () 
	{
		return new CertificateValuesType();
	}
	public function createRevocationValuesType () 
	{
		return new RevocationValuesType();
	}
	public function createQualifyingPropertiesReference () 
	{
		return new QualifyingPropertiesReference();
	}
	public function createCertIDType () 
	{
		return new CertIDType();
	}
	public function createSignaturePolicyIdType () 
	{
		return new SignaturePolicyIdType();
	}
	public function createSPUserNotice () 
	{
		return new SPUserNotice();
	}
	public function createNoticeReferenceType () 
	{
		return new NoticeReferenceType();
	}
	public function createCommitmentTypeQualifiersListType () 
	{
		return new CommitmentTypeQualifiersListType();
	}
	public function createClaimedRolesListType () 
	{
		return new ClaimedRolesListType();
	}
	public function createCertifiedRolesListType () 
	{
		return new CertifiedRolesListType();
	}
	public function createDigestAlgAndValueType () 
	{
		return new DigestAlgAndValueType();
	}
	public function createSigPolicyQualifiersListType () 
	{
		return new SigPolicyQualifiersListType();
	}
	public function createIntegerListType () 
	{
		return new IntegerListType();
	}
	public function createCRLRefsType () 
	{
		return new CRLRefsType();
	}
	public function createCRLRefType () 
	{
		return new CRLRefType();
	}
	public function createCRLIdentifierType () 
	{
		return new CRLIdentifierType();
	}
	public function createOCSPRefsType () 
	{
		return new OCSPRefsType();
	}
	public function createOCSPRefType () 
	{
		return new OCSPRefType();
	}
	public function createResponderIDType () 
	{
		return new ResponderIDType();
	}
	public function createOCSPIdentifierType () 
	{
		return new OCSPIdentifierType();
	}
	public function createOtherCertStatusRefsType () 
	{
		return new OtherCertStatusRefsType();
	}
	public function createCRLValuesType () 
	{
		return new CRLValuesType();
	}
	public function createOCSPValuesType () 
	{
		return new OCSPValuesType();
	}
	public function createOtherCertStatusValuesType () 
	{
		return new OtherCertStatusValuesType();
	}
	public function createXAdESTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_XAdESTimeStamp_QNAME, XAdESTimeStampType::class, NULL, $value);
	}
	public function createSigningTime ($value) // [ZonedDateTime value]
	{
		return new JAXBElement(self::$_SigningTime_QNAME, \DateTime::class, NULL, $value);
	}
	public function createSPURI ($value) // [String value]
	{
		return new JAXBElement(self::$_SPURI_QNAME, 'String', NULL, $value);
	}
	public function createAllDataObjectsTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_AllDataObjectsTimeStamp_QNAME, XAdESTimeStampType::class, NULL, $value);
	}
	public function createIndividualDataObjectsTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_IndividualDataObjectsTimeStamp_QNAME, XAdESTimeStampType::class, NULL, $value);
	}
	public function createSignatureTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_SignatureTimeStamp_QNAME, XAdESTimeStampType::class, NULL, $value);
	}
	public function createCompleteCertificateRefs ($value) // [CompleteCertificateRefsType value]
	{
		return new JAXBElement(self::$_CompleteCertificateRefs_QNAME, CompleteCertificateRefsType::class, NULL, $value);
	}
	public function createCompleteRevocationRefs ($value) // [CompleteRevocationRefsType value]
	{
		return new JAXBElement(self::$_CompleteRevocationRefs_QNAME, CompleteRevocationRefsType::class, NULL, $value);
	}
	public function createAttributeCertificateRefs ($value) // [CompleteCertificateRefsType value]
	{
		return new JAXBElement(self::$_AttributeCertificateRefs_QNAME, CompleteCertificateRefsType::class, NULL, $value);
	}
	public function createAttributeRevocationRefs ($value) // [CompleteRevocationRefsType value]
	{
		return new JAXBElement(self::$_AttributeRevocationRefs_QNAME, CompleteRevocationRefsType::class, NULL, $value);
	}
	public function createSigAndRefsTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_SigAndRefsTimeStamp_QNAME, XAdESTimeStampType::class, NULL, $value);
	}
	public function createRefsOnlyTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_RefsOnlyTimeStamp_QNAME, XAdESTimeStampType::class, NULL, $value);
	}
	public function createCertificateValues ($value) // [CertificateValuesType value]
	{
		return new JAXBElement(self::$_CertificateValues_QNAME, CertificateValuesType::class, NULL, $value);
	}
	public function createRevocationValues ($value) // [RevocationValuesType value]
	{
		return new JAXBElement(self::$_RevocationValues_QNAME, RevocationValuesType::class, NULL, $value);
	}
	public function createAttrAuthoritiesCertValues ($value) // [CertificateValuesType value]
	{
		return new JAXBElement(self::$_AttrAuthoritiesCertValues_QNAME, CertificateValuesType::class, NULL, $value);
	}
	public function createAttributeRevocationValues ($value) // [RevocationValuesType value]
	{
		return new JAXBElement(self::$_AttributeRevocationValues_QNAME, RevocationValuesType::class, NULL, $value);
	}
	public function createArchiveTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_ArchiveTimeStamp_QNAME, XAdESTimeStampType::class, NULL, $value);
	}
	public function createUnsignedSignaturePropertiesCounterSignature ($value) // [CounterSignature value]
	{
		return new JAXBElement(self::$_UnsignedSignaturePropertiesCounterSignature_QNAME, CounterSignature::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesSignatureTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_SignatureTimeStamp_QNAME, XAdESTimeStampType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesCompleteCertificateRefs ($value) // [CompleteCertificateRefsType value]
	{
		return new JAXBElement(self::$_CompleteCertificateRefs_QNAME, CompleteCertificateRefsType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesCompleteRevocationRefs ($value) // [CompleteRevocationRefsType value]
	{
		return new JAXBElement(self::$_CompleteRevocationRefs_QNAME, CompleteRevocationRefsType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesAttributeCertificateRefs ($value) // [CompleteCertificateRefsType value]
	{
		return new JAXBElement(self::$_AttributeCertificateRefs_QNAME, CompleteCertificateRefsType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesAttributeRevocationRefs ($value) // [CompleteRevocationRefsType value]
	{
		return new JAXBElement(self::$_AttributeRevocationRefs_QNAME, CompleteRevocationRefsType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesSigAndRefsTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_SigAndRefsTimeStamp_QNAME, XAdESTimeStampType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesRefsOnlyTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_RefsOnlyTimeStamp_QNAME, XAdESTimeStampType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesCertificateValues ($value) // [CertificateValuesType value]
	{
		return new JAXBElement(self::$_CertificateValues_QNAME, CertificateValuesType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesRevocationValues ($value) // [RevocationValuesType value]
	{
		return new JAXBElement(self::$_RevocationValues_QNAME, RevocationValuesType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesAttrAuthoritiesCertValues ($value) // [CertificateValuesType value]
	{
		return new JAXBElement(self::$_AttrAuthoritiesCertValues_QNAME, CertificateValuesType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesAttributeRevocationValues ($value) // [RevocationValuesType value]
	{
		return new JAXBElement(self::$_AttributeRevocationValues_QNAME, RevocationValuesType::class, UnsignedSignatureProperties::class, $value);
	}
	public function createUnsignedSignaturePropertiesArchiveTimeStamp ($value) // [XAdESTimeStampType value]
	{
		return new JAXBElement(self::$_ArchiveTimeStamp_QNAME, XAdESTimeStampType::class, UnsignedSignatureProperties::class, $value);
	}
}
ObjectFactory::__staticinit(); // initialize static vars for this class on load
