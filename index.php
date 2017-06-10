<?php
$filename = "test.jpg";
$output = exec("python face_detect.py test.jpg cascade.xml");//Bize x, y yi genişlik, yüksekliği döndürüyor yüzlerin. 
$output = str_replace("[", "", $output);
$output = str_replace("]", "", $output);
$output = str_replace(" ", "", $output);
$coors = explode(",", $output);
?>
<html>
	<head>
		<!--proceesing i kullandığımız için bunun js dosyasını ekledik.-->
		<script src="processing.min.js" type="text/javascript"></script>	
		<style type="text/css">
		body {
			background-color: rgb(248,152,33);
			font-family: Ubuntu;
		}
		</style>
	</head>
	<body> 
		<img id="img" style="visibility:hidden" src="test.jpg">
		<script type="text/javascript">
			var coors = <?php echo json_encode($coors);?>;
			function called(param){
				return coors[param];
			}
		</script>
		<script type="application/processing" target="sketch">
			PImage pimg;
			PFont font;
			void setup() {//program ilk çalıştığında bu çalışıyor.
				fill(175,60,60);//boyuyor ekranı o renge boyuyor.Arka planı turuncuya boyuyor.
			    pimg = loadImage("test.jpg");
				var c = document.getElementById("cnvs");
			    var ctx = c.getContext("2d");//2 boyutlu çiizim yaptırcam diyorsun.
			    var img = document.getElementById("img"); 
			    c.width=img.width;
			    c.height=img.height;
			    size(c.width, c.height);//resim ile canvas eşit olsun diye
			    noFill();//içini doldurma demek. boş olsun demek.
				rectMode(CORNER);
				font = loadFont("Ubuntu Light"); 
				textFont(font); 
			}

			String[] counties = {"Adana","Adiyaman","Afyonkarahisar","Aksaray","Amasya","Ankara","Antalya","Ardahan","Artvin","Aydın","Balıkesir","Bartın","Batman","Bayburt","Bilecik","Bingöl","Bitlis","Bolu","Burdur","Bursa","Çanakkale","Çankırı","Çorum","Denizli","Diyarbakır","Düzce","Edirne","Elazığ","Erzincan","Erzurum","Eskişehir","Gaziantep","Giresun","Gümüşhane","Hakkari","Hatay","Iğdır","Isparta","İstanbul","İzmir","Kahramanmaraş","Karabük","Karaman","Kars","Kastamonu","Kayseri","Kırıkkale","Kırklareli","Kırşehir","Kilis","Kocaeli","Konya","Kütahya","Malatya","Manisa","Mardin","Mersin","Muğla","Muş","Nevşehir","Niğde","Ordu","Osmaniye","Rize","Sakarya","Samsun","Siirt","Sinop","Sivas","Şanlıurfa","Şırnak","Tekirdağ","Tokat","Trabzon","Tunceli","Uşak","Van","Yalova","Yozgat","Zonguldak"};
			void draw() {
			    image(pimg, 0, 0);//ekrana bir resim çizcem diyor.Yukarıda aldığımızı veriyor 0 a 0 dan başlıyor çizmeye.
				for(int i=0; i<coors.length; i+=4) {//bir yüzde 4 tane kenar var o yüzden 4 er artırıyoruz.Döngü her döndüğünde başka bir yüze geçiş yapar.
					noFill();//birazdan ben sana bişi dicem ama onları doldurma demek.
					stroke(255);//Çizgiyi belirgin hale getiriyor.tüm çizgiler böyle olsun dedik.
					rect(called(i),called(i+1),called(i+2),called(i+3));//Dikdörtgen çiziyor.x, y, genişlik, yükseklik. js değişkeninde olan değerleri burada alp parametre olarak yolluyoruz.Yüz tespiti için.
					noStroke();//stroke u sil artık dedik.
					fill(236,207,17,220);
					rect(called(i),called(i+1)-called(i+3)/3-5,called(i+2),called(i+3)/3);//İl tespiti için.
					fill(207,99,4);
					textSize(called(i+3)/3-7);//İl yazıcaz ya onun boyutu
					String str = counties[called(i)%78];//Adam aynı resmi yüklediğinde aynı ili versin diye
					//aşağıda seçilen ilin doğru şekilde kutu içerisine yazılması için doğru koordinatlar yazılmıştır.
					int x = (called(i+2) - textWidth(str)) / 2 + int(called(i));
					int y = ((called(i+3) - (textDescent() * 0.8 - textAscent() * 0.8)) / 2 + int(called(i+1))) - called(i+3)/1.5;
					text(str, int(x), int(y));//İli kutuya yazıyoruz.ekrana yazı yazıyorsun
				}
				if(frameCount > 2000) noLoop();
			}/*
		  	void txt(T, X, Y, W, H) { // Set button text.
			    float scalar = 0.8; // Different for each font.
			    fill(0);
			    float tW = textWidth(T);
			    float tH = textDescent() * scalar - textAscent() * scalar;
			    float tX = X + (W - tW)/2;
			    float tY = Y + (H - tH)/2; 
			    text(T, int(tX), int(tY));
			}  */
		</script>
		<canvas id="cnvs"/></canvas><!--çizim yapmak için element-->
	</body>
</html>