#include <iostream>
int main(){
using namespace std;
int tc,a,b,ans,count=0;
cin>>tc;
while(tc!=0){
cin>>a;
cin>>b;
ans=a+b;
cout<<"case #"<<++count<<":"<<ans<<endl;
--tc
}//end of tc
return 0;
}
